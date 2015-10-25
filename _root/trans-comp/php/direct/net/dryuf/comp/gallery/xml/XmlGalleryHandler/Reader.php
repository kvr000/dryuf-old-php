<?php

namespace net\dryuf\comp\gallery\xml\XmlGalleryHandler;


class Reader extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getAttrMandatory($attrList, $key)
	{
		$value = $attrList->getValue($key);
		if (is_null($value))
			throw new \net\dryuf\core\ReportException("value not found: ".$key);
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getAttrDefault($attrList, $key, $defaultValue)
	{
		$value = $attrList->getValue($key);
		if (is_null($value))
			return $defaultValue;
		return $value;
	}

	(=f_I_x= msg="java.lang.NoSuchFieldException: readMapping")
	public <init>(XmlGalleryHandler owner, XmlMappedParser parser) {
	    this.owner = owner;
	    if (readMapping == null) {
	        readMapping = XmlMappedTree.create(Reader.class, null, null, "gallery", XmlMappedTree.create(Reader.class, null, null, "locations", XmlMappedTree.create(Reader.class, null, null, "location", XmlMappedTree.create(Reader.class, "startLocation", "endLocation")), "sections", XmlMappedTree.create(Reader.class, "startSections", "endSections", "section", XmlMappedTree.create(Reader.class, "startSection", "endSection", "title", XmlMappedTree.create(Reader.class, null, "endSectionTitle"), "description", XmlMappedTree.create(Reader.class, null, "endSectionDescription"), "records", XmlMappedTree.create(Reader.class, null, null, "record", XmlMappedTree.create(Reader.class, "startRecord", "endRecord", "title", XmlMappedTree.create(Reader.class, null, "endRecordTitle"), "description", XmlMappedTree.create(Reader.class, null, "endRecordDescription")))))));
	    }
	    parser.setupMapped(this, readMapping);
	    this.read_idxSection = 0;
	}(=x_I_f=)/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startLocation($tag, $attrList)
	{
		$this->read_curLocation = new \net\dryuf\comp\gallery\GalleryLocation();
		$this->read_curLocation->setName($this->getAttrMandatory($attrList, "id"));
		$this->read_curLocation->setStore($this->getAttrMandatory($attrList, "store"));
		$this->read_curLocation->setThumb($this->getAttrMandatory($attrList, "thumb"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endLocation($tag, $content)
	{
		if ($this->owner->locationsHash->isEmpty())
			$this->owner->locationsHash->put("", $this->read_curLocation);
		$this->owner->locationsHash->put($this->read_curLocation->getName(), $this->read_curLocation);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startSections($tag, $attrList)
	{
		$this->owner->isMulti = !is_null($attrList->getValue("multi")) ? \net\dryuf\core\Dryuf::convertBool(\net\dryuf\core\Dryuf::convertBool($attrList->getValue("multi"))) : true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startSection($tag, $attrList)
	{
		$this->read_currentSection = new \net\dryuf\comp\gallery\MemoryGalleryHandler\GallerySectionMemory();
		$this->read_currentSection->setDisplayName($this->getAttrMandatory($attrList, "id"));
		$this->read_currentSection->location = $this->getAttrMandatory($attrList, "location");
		$this->read_currentSection->setTitle("");
		$this->read_currentSection->setDescription("");
		$this->read_idxSection = 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endSectionTitle($tag, $content)
	{
		$this->read_currentSection->setTitle($content);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endSectionDescription($tag, $content)
	{
		$this->read_currentSection->setDescription($content);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endSection($tag, $content)
	{
		if (!is_null($this->read_currentRecord)) {
			$this->read_currentRecord->sectionNext = null;
			$this->read_currentRecord->fullNext = null;
		}
		if (is_null($this->read_currentSection->location))
			$this->read_currentSection->location = "";
		$this->read_currentSection->setRecordCount($this->read_idxSection);
		(=f_I_x= msg="java.lang.NoSuchMethodException: no method net.dryuf.comp.gallery.xml.XmlGalleryHandler.read_addSection(net.dryuf.comp.gallery.MemoryGalleryHandler$GallerySectionMemory)")owner.read_addSection(this.read_currentSection);(=x_I_f=)
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endSections($tag, $content)
	{
		if (!is_null($this->read_currentRecord))
			$this->read_currentRecord->fullNext = null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startRecord($tag, $attrList)
	{
		$oldRecord = $this->read_currentRecord;
		$this->read_currentRecord = new \net\dryuf\comp\gallery\MemoryGalleryHandler\GalleryRecordMemory();
		$this->read_currentRecord->fullPrevious = $oldRecord;
		if (!is_null($oldRecord))
			$oldRecord->fullNext = $this->read_currentRecord;
		if ($this->read_idxSection == 0) {
			if (!is_null($oldRecord))
				$oldRecord->sectionNext = null;
			$this->read_currentRecord->sectionPrevious = null;
		}
		else {
			$this->read_currentRecord->sectionPrevious = $oldRecord;
			$oldRecord->sectionNext = $this->read_currentRecord;
		}
		$file = $this->getAttrMandatory($attrList, "file");
		$this->read_currentRecord->setGallerySection($this->read_currentSection->getPk());
		$this->read_currentRecord->setDisplayName($file);
		$this->read_currentRecord->setTitle($file);
		$this->read_currentRecord->setDescription($file);
		$this->read_currentRecord->setLocation($this->getAttrDefault($attrList, "location", ""));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endRecordTitle($tag, $content)
	{
		$this->read_currentRecord->setTitle($content);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endRecordDescription($tag, $content)
	{
		$this->read_currentRecord->setDescription($content);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endRecord($tag, $content)
	{
		$this->read_currentRecord->setRecordCounter($this->read_idxSection++);
		(=f_I_x= msg="java.lang.NoSuchMethodException: no method net.dryuf.comp.gallery.xml.XmlGalleryHandler.read_addRecord(net.dryuf.comp.gallery.MemoryGalleryHandler$GallerySectionMemory, net.dryuf.comp.gallery.MemoryGalleryHandler$GalleryRecordMemory)")owner.read_addRecord(this.read_currentSection, this.read_currentRecord);(=x_I_f=)
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlGalleryHandler')
	*/
	public				$owner;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryLocation')
	*/
	public				$read_curLocation;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\MemoryGalleryHandler\GallerySectionMemory')
	*/
	public				$read_currentSection;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\MemoryGalleryHandler\GalleryRecordMemory')
	*/
	public				$read_currentRecord;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public				$read_idxSection = 0;
};


?>
