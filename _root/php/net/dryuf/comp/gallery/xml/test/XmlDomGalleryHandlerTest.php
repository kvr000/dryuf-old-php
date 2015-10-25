<?php

namespace net\dryuf\comp\gallery\xml\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class XmlDomGalleryHandlerTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testAll()
	{
		$galleryHandler = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler($this->createCallerContext(), "net/dryuf/comp/gallery/xml/test/gallery_ut0/");
		$sections = $galleryHandler->listSections();
		\net\dryuf\tenv\DAssert::assertEquals(3, $sections->size());
		$galleryHandler->setCurrentSectionIdx(0);
		$records = $galleryHandler->listSectionRecords();
		\net\dryuf\tenv\DAssert::assertEquals(2, $records->size());
		$record = $records->get(0);
		\net\dryuf\tenv\DAssert::assertEquals("img_5989.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("img_5989.jpg", $record->getDisplayName());
		\net\dryuf\tenv\DAssert::assertEquals("first picture", $record->getDescription());
		\net\dryuf\tenv\DAssert::assertEquals(\net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture, $record->getRecordType());
		$record = $records->get(1);
		\net\dryuf\tenv\DAssert::assertEquals("img_5993.jpg", $record->getDisplayName());
		\net\dryuf\tenv\DAssert::assertEquals("img_5993.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("second picture", $record->getDescription());
		\net\dryuf\tenv\DAssert::assertEquals(\net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture, $record->getRecordType());
		$galleryHandler->setCurrentSectionIdx(1);
		$records = $galleryHandler->listSectionRecords();
		\net\dryuf\tenv\DAssert::assertEquals(2, $records->size());
		$record = $records->get(0);
		\net\dryuf\tenv\DAssert::assertEquals("20111113_194931.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals(\net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture, $record->getRecordType());
		\net\dryuf\tenv\DAssert::assertNotNull($galleryHandler->setCurrentRecord($sections->get(1)->getDisplayName(), null, "20111113_194931.jpg"));
		$sources = $galleryHandler->listRecordSources();
		\net\dryuf\tenv\DAssert::assertNull($sources);
		$record = $records->get(1);
		\net\dryuf\tenv\DAssert::assertEquals("20111113_201204.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals(\net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture, $record->getRecordType());
		\net\dryuf\tenv\DAssert::assertTrue(($record->getTitle() === "20111113_194931.jpg") == false || ($record->getDisplayName() === "20111113_194931.jpg") == false || ($record->getDescription() === "Formula Rosa"));
		\net\dryuf\tenv\DAssert::assertTrue(($record->getTitle() === "20111113_201204.jpg") == false || ($record->getDisplayName() === "20111113_201204.jpg") == false || ($record->getDescription() === "Ferrari World - entrance gate."));
		\net\dryuf\tenv\DAssert::assertNotNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), null, "20111113_194931.jpg"));
		\net\dryuf\tenv\DAssert::assertNotNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), null, "20111113_201204.jpg"));
		$galleryHandler->setCurrentSectionIdx(2);
		$records = $galleryHandler->listSectionRecords();
		\net\dryuf\tenv\DAssert::assertEquals(1, $records->size());
		$record = $records->get(0);
		\net\dryuf\tenv\DAssert::assertEquals("bum.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("bum.jpg", $record->getDisplayName());
		\net\dryuf\tenv\DAssert::assertEquals("bum", $record->getDescription());
		\net\dryuf\tenv\DAssert::assertEquals(\net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Video, $record->getRecordType());
		\net\dryuf\tenv\DAssert::assertNotNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), "thumb/", $record->getDisplayName()));
		$sources = $galleryHandler->listRecordSources();
		\net\dryuf\tenv\DAssert::assertNotNull($sources);
		\net\dryuf\tenv\DAssert::assertEquals(1, $sources->size());
		$source = $sources->get(0);
		\net\dryuf\tenv\DAssert::assertEquals("bum.mp4", $source->getDisplayName());
		\net\dryuf\tenv\DAssert::assertNotNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), "thumb/", "bum.jpg"));
		\net\dryuf\tenv\DAssert::assertNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), null, "bum.jpg"));
		\net\dryuf\tenv\DAssert::assertNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), "thumb/", "bum.mp4"));
		\net\dryuf\tenv\DAssert::assertNotNull($galleryHandler->setCurrentRecord($galleryHandler->getCurrentSection()->getDisplayName(), null, "bum.mp4"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testSection()
	{
		$galleryHandler = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler($this->createCallerContext(), "net/dryuf/comp/gallery/xml/test/gallery_ut0/");
		\net\dryuf\tenv\DAssert::assertNotNull($section = $galleryHandler->setCurrentSection("ferrari-world"));
		\net\dryuf\tenv\DAssert::assertEquals(2, $section->getRecordCount());
		\net\dryuf\tenv\DAssert::assertEquals("Visiting Ferrari World", $section->getDescription());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testRecordCounter()
	{
		$galleryHandler = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler($this->createCallerContext(), "net/dryuf/comp/gallery/xml/test/gallery_ut0/");
		\net\dryuf\tenv\DAssert::assertNotNull($galleryRecord = $galleryHandler->setCurrentRecord("ferrari-world", null, "20111113_194931.jpg"));
		\net\dryuf\tenv\DAssert::assertEquals(0, $galleryRecord->getRecordCounter());
	}
};


?>
