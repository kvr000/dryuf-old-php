<?php

namespace net\dryuf\comp\poll;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\poll\PollRecord\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\poll\PollHeader', composPkClazz = 'integer', composPath = "pk.pollId", additionalPkFields = { "userId" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "voteOption" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "Poll.vote", roleGet = "Poll.get", roleSet = "Poll.owner", roleDel = "Poll.owner")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "PollRecord")
*/
class PollRecord extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\poll\PollRecord\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollRecord\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "voteOption")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.vote", roleGet = "Poll.get", roleSet = "Poll.owner", roleDel = "Poll.owner")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$voteOption;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId_)
	{
		$this->pk->setUserId($userId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getUserId()
	{
		return $this->pk->getUserId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setVoteOption($voteOption_)
	{
		$this->voteOption = $voteOption_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getVoteOption()
	{
		return $this->voteOption;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPollId($pollId_)
	{
		$this->pk->setPollId($pollId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPollId()
	{
		return $this->pk->getPollId();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollRecord\Pk')
	*/
	public function			getPk()
	{
		return $this->pk;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($pk_)
	{
		$this->pk = $pk_;
	}
};


?>
