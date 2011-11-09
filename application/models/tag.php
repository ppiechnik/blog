<?php
class Tag extends DataMapper
{
	public $has_many = array('post');

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllTags()
	{
		$tags = $this->get();
		$tags_names = array();
		foreach ($tags as $tag) {
			$tags_names[] = $tag->name;
		}
		return $tags_names;
	}	
}
