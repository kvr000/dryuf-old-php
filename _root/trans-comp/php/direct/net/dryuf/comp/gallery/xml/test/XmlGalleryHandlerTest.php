<?php

namespace net\dryuf\comp\gallery\xml\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class XmlGalleryHandlerTest extends \net\dryuf\tenv\AppTenvObject
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
	public function			testHandler()
	{
		$galleryHandler = new \net\dryuf\comp\gallery\xml\XmlGalleryHandler($this->createCallerContext(), "net/dryuf/comp/gallery/xml/test/gallery_ut0/");
		$sections = $galleryHandler->listSections();
		\net\dryuf\tenv\DAssert::assertEquals(3, $sections->size());
		$galleryHandler->setCurrentSectionIdx(0);
		$records = $galleryHandler->listSectionRecords();
		\net\dryuf\tenv\DAssert::assertEquals(2, $records->size());
		$record = $records->get(0);
		\net\dryuf\tenv\DAssert::assertEquals("img_5989.jpg", $record->getDisplayName());
		\net\dryuf\tenv\DAssert::assertEquals("img_5989.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("first picture", $record->getDescription());
		$record = $records->get(1);
		\net\dryuf\tenv\DAssert::assertEquals("img_5993.jpg", $record->getDisplayName());
		\net\dryuf\tenv\DAssert::assertEquals("img_5993.jpg", $record->getTitle());
		\net\dryuf\tenv\DAssert::assertEquals("second picture", $record->getDescription());
		$galleryHandler->setCurrentSectionIdx(1);
		$records = $galleryHandler->listSectionRecords();
		\net\dryuf\tenv\DAssert::assertEquals(2, $records->size());
		$record = $records->get(0);
		\net\dryuf\tenv\DAssert::assertEquals("20111113_194931.jpg", $record->getTitle());
		$record = $records->get(1);
		\net\dryuf\tenv\DAssert::assertEquals("20111113_201204.jpg", $record->getTitle());
		$record = $records->get(0);
		\net\dryuf\tenv\DAssert::assertTrue(($record->getTitle() === "20111113_194931.jpg") == false || ($record->getDisplayName() === "20111113_194931.jpg") == false || ($record->getDescription() === "Formula Rosa"));
		$record = $records->get(1);
		\net\dryuf\tenv\DAssert::assertTrue(($record->getTitle() === "20111113_201204.jpg") == false || ($record->getDisplayName() === "20111113_201204.jpg") == false || ($record->getDescription() === "Ferrari World - entrance gate."));
	}
};


?>
