<?php
require_once __DIR__ . '/../models/BlogPostModel.php';

class BlogService {
    private static $pdo = null;

    private static function getPdo() {
        if (self::$pdo === null) {
            self::$pdo = require __DIR__ . '/../../bootstrap.php';
        }
        return self::$pdo;
    }

    /**
     * Get blog posts with pagination
     */
    public static function getBlogPosts(string $language = 'en', int $page = 1, int $limit = 20): array {
        $pdo = self::getPdo();
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT * FROM blog_posts 
                WHERE language = ? AND visible = 1 
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$language, $limit, $offset]);
        $posts = $stmt->fetchAll();
        
        return array_map(function($post) {
            return new BlogPostModel($post);
        }, $posts);
    }

    /**
     * Get total number of blog posts for pagination
     */
    public static function getTotalBlogPosts(string $language = 'en'): int {
        $pdo = self::getPdo();
        $sql = "SELECT COUNT(*) as total FROM blog_posts WHERE language = ? AND visible = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$language]);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Get blog post by ID
     */
    public static function getBlogPostById(int $id): ?BlogPostModel {
        $pdo = self::getPdo();
        $sql = "SELECT * FROM blog_posts WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        
        return $post ? new BlogPostModel($post) : null;
    }

    /**
     * Create new blog post
     */
    public static function createBlogPost(array $data): int {
        $pdo = self::getPdo();
        
        $insertData = [
            'language' => $data['language'],
            'main_title' => $data['main_title'],
            'main_text' => $data['main_text'],
            'main_image' => $data['main_image'],
            'secondary_title' => $data['secondary_title'],
            'secondary_text' => $data['secondary_text'],
            'secondary_image' => $data['secondary_image'],
            'gallery_images' => json_encode($data['gallery_images'] ?? []),
            'visible' => $data['visible'] ?? true
        ];
        
        $columns = implode(', ', array_keys($insertData));
        $placeholders = ':' . implode(', :', array_keys($insertData));
        
        $sql = "INSERT INTO blog_posts ({$columns}) VALUES ({$placeholders})";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($insertData);
        
        return (int) $pdo->lastInsertId();
    }

    /**
     * Update blog post
     */
    public static function updateBlogPost(int $id, array $data): bool {
        $pdo = self::getPdo();
        
        $updateData = [
            'language' => $data['language'],
            'main_title' => $data['main_title'],
            'main_text' => $data['main_text'],
            'main_image' => $data['main_image'],
            'secondary_title' => $data['secondary_title'],
            'secondary_text' => $data['secondary_text'],
            'secondary_image' => $data['secondary_image'],
            'gallery_images' => json_encode($data['gallery_images'] ?? []),
            'visible' => $data['visible'] ?? true
        ];
        
        $setClause = implode(', ', array_map(fn($col) => "{$col} = :{$col}", array_keys($updateData)));
        $sql = "UPDATE blog_posts SET {$setClause} WHERE id = :id";
        
        $updateData['id'] = $id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($updateData);
        
        return $stmt->rowCount() > 0;
    }

    /**
     * Delete blog post
     */
    public static function deleteBlogPost(int $id): bool {
        $pdo = self::getPdo();
        $sql = "DELETE FROM blog_posts WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        return $stmt->rowCount() > 0;
    }

    /**
     * Get all blog posts for admin (including hidden)
     */
    public static function getAllBlogPosts(): array {
        $pdo = self::getPdo();
        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        
        return array_map(function($post) {
            return new BlogPostModel($post);
        }, $posts);
    }

    /**
     * Toggle blog post visibility
     */
    public static function toggleVisibility(int $id): bool {
        $pdo = self::getPdo();
        $post = self::getBlogPostById($id);
        
        if (!$post) {
            return false;
        }
        
        $currentVisibility = $post->isVisible();
        $newVisibility = !$currentVisibility;
        
        // Ensure we're working with proper boolean values
        $newVisibility = (bool) $newVisibility;
        
        $sql = "UPDATE blog_posts SET visible = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$newVisibility ? 1 : 0, $id]);
        
        return $stmt->rowCount() > 0;
    }

    /**
     * Get pagination info
     */
    public static function getPaginationInfo(string $language = 'en', int $currentPage = 1, int $limit = 20): array {
        $totalPosts = self::getTotalBlogPosts($language);
        $totalPages = ceil($totalPosts / $limit);
        
        return [
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'total_posts' => $totalPosts,
            'limit' => $limit,
            'has_previous' => $currentPage > 1,
            'has_next' => $currentPage < $totalPages,
            'previous_page' => $currentPage > 1 ? $currentPage - 1 : null,
            'next_page' => $currentPage < $totalPages ? $currentPage + 1 : null
        ];
    }

    /**
     * Generate pagination links
     */
    public static function generatePaginationLinks(array $paginationInfo): array {
        $currentPage = $paginationInfo['current_page'];
        $totalPages = $paginationInfo['total_pages'];
        $links = [];
        
        // Always show page 1
        $links[] = [
            'page' => 1,
            'label' => '1',
            'active' => $currentPage === 1,
            'url' => '/blog?page=1'
        ];
        
        // Show ellipsis if needed
        if ($currentPage > 4) {
            $links[] = [
                'page' => null,
                'label' => '...',
                'active' => false,
                'url' => null
            ];
        }
        
        // Show current page and adjacent pages
        $start = max(2, $currentPage - 1);
        $end = min($totalPages - 1, $currentPage + 1);
        
        for ($i = $start; $i <= $end; $i++) {
            if ($i !== 1 && $i !== $totalPages) {
                $links[] = [
                    'page' => $i,
                    'label' => (string)$i,
                    'active' => $currentPage === $i,
                    'url' => "/blog?page=$i"
                ];
            }
        }
        
        // Show ellipsis if needed
        if ($currentPage < $totalPages - 3) {
            $links[] = [
                'page' => null,
                'label' => '...',
                'active' => false,
                'url' => null
            ];
        }
        
        // Always show last page
        if ($totalPages > 1) {
            $links[] = [
                'page' => $totalPages,
                'label' => (string)$totalPages,
                'active' => $currentPage === $totalPages,
                'url' => "/blog?page=$totalPages"
            ];
        }
        
        return $links;
    }
}
