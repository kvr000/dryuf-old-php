<?php

namespace net\dryuf\comp\gallery\sql\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SqlGalleryHandlerTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		addGalleryRecord($handler, $displayName, $title, $description)
	{
		$record = new \net\dryuf\comp\gallery\GalleryRecord();
		$record->setDisplayName($displayName);
		$record->setTitle($title);
		$record->setDescription($description);
		$handler->addRecord($record, \net\dryuf\io\FileDataImpl::createFromNameBytes("a.jpeg", self::$IMAGE_DATA));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public function			initGallery()
	{
		$galleryHandler = $this->getAppContainer()->createBeaned('net\dryuf\comp\gallery\sql\SqlGalleryBo', null)->openCreateGalleryRef($this->createCallerContext(), \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\test\SqlGalleryHandlerTest'), "test");
		$galleryHandler->cleanGallery();
		$gallerySection = new \net\dryuf\comp\gallery\GallerySection();
		$gallerySection->setDisplayName("section1");
		$gallerySection->setTitle("section1");
		$gallerySection->setDescription("section1");
		$galleryHandler->addSection($gallerySection);
		$galleryHandler->setCurrentSectionIdx(0);
		$this->addGalleryRecord($galleryHandler, "picture11.jpg", "picture11", "description11");
		$this->addGalleryRecord($galleryHandler, "picture12.jpg", "picture12", "description12");
		$gallerySection = new \net\dryuf\comp\gallery\GallerySection();
		$gallerySection->setDisplayName("section2");
		$gallerySection->setTitle("section2");
		$gallerySection->setDescription("section2");
		$galleryHandler->addSection($gallerySection);
		$galleryHandler->setCurrentSection("section2");
		$this->addGalleryRecord($galleryHandler, "picture21.jpg", "picture21", "description21");
		$this->addGalleryRecord($galleryHandler, "picture22.jpg", "picture22", "description22");
		return $galleryHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testHandler()
	{
		$this->galleryHandler = $this->initGallery();
		$this->galleryHandler->setCurrentSectionIdx(0);
		$records = $this->galleryHandler->listSectionRecords();
		\net\dryuf\tenv\DAssert::assertEquals(2, $records->size());
		\net\dryuf\tenv\DAssert::assertEquals("picture11", $records->get(0)->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("picture12", $records->get(1)->getTitle());
		\net\dryuf\tenv\DAssert::assertNotNull($this->galleryHandler->setCurrentRecord("section2", null, "picture21.jpg"));
		$section_dirs = $this->galleryHandler->getSectionDirs();
		$full_dirs = $this->galleryHandler->getFullDirs();
		\net\dryuf\tenv\DAssert::assertNull($section_dirs[0]);
		\net\dryuf\tenv\DAssert::assertNotNull($section_dirs[1]);
		\net\dryuf\tenv\DAssert::assertEquals("picture22", $section_dirs[1]->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("picture12", $full_dirs[0]->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("picture22", $full_dirs[1]->getTitle());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public				$galleryHandler;

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	static				$IMAGE_DATA;

	public static function		_initManualStatic()
	{
		self::$IMAGE_DATA = implode(array_map('chr', array(
			-119,
			80,
			78,
			71,
			13,
			10,
			26,
			10,
			0,
			0,
			0,
			13,
			73,
			72,
			68,
			82,
			0,
			0,
			0,
			1,
			0,
			0,
			0,
			1,
			8,
			2,
			0,
			0,
			0,
			-112,
			119,
			83,
			-34,
			0,
			0,
			0,
			1,
			115,
			82,
			71,
			66,
			0,
			-82,
			-50,
			28,
			-23,
			0,
			0,
			0,
			9,
			112,
			72,
			89,
			115,
			0,
			0,
			11,
			19,
			0,
			0,
			11,
			19,
			1,
			0,
			-102,
			-100,
			24,
			0,
			0,
			0,
			7,
			116,
			73,
			77,
			69,
			7,
			-37,
			12,
			15,
			10,
			47,
			41,
			116,
			-121,
			-98,
			-52,
			0,
			0,
			0,
			25,
			116,
			69,
			88,
			116,
			67,
			111,
			109,
			109,
			101,
			110,
			116,
			0,
			67,
			114,
			101,
			97,
			116,
			101,
			100,
			32,
			119,
			105,
			116,
			104,
			32,
			71,
			73,
			77,
			80,
			87,
			-127,
			14,
			23,
			0,
			0,
			0,
			12,
			73,
			68,
			65,
			84,
			8,
			-41,
			99,
			-8,
			-1,
			-1,
			63,
			0,
			5,
			-2,
			2,
			-2,
			-36,
			-52,
			89,
			-25,
			0,
			0,
			0,
			0,
			73,
			69,
			78,
			68,
			-82,
			66,
			96,
			-126
		)));
	}

};

\net\dryuf\comp\gallery\sql\test\SqlGalleryHandlerTest::_initManualStatic();


?>
