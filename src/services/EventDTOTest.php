<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/EventDTO.php';

class EventDTOTest extends TestCase {
    public function testDTOConstructionAndGetters() {
        $dto = new EventDTO(
            5,
            '/img.png',
            ['en'=>'Title'],
            ['en'=>'Desc'],
            'http://book',
            ['en'=>'Book'],
            ['en'=>'Alt']
        );
        $this->assertEquals(5, $dto->getId());
        $this->assertEquals('/img.png', $dto->getImage());
        $this->assertEquals(['en'=>'Title'], $dto->getTitle());
        $this->assertEquals(['en'=>'Desc'], $dto->getDesc());
        $this->assertEquals('http://book', $dto->getBookUrl());
        $this->assertEquals(['en'=>'Book'], $dto->getBookLabel());
        $this->assertEquals(['en'=>'Alt'], $dto->getImageAlt());
    }
} 