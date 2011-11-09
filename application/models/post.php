<?php

class Post extends DataMapper
{
	public $has_many = array('tag');

	public function __construct()
	{
		parent::__construct();
	}
	
	public function getByIndex($count, $params)
	{
		$post = new stdClass();
		
		$post->count = $this
			->order_by('posts.created', 'DESC')
			->get()->result_count();
		
		$post->row = $this
			->order_by('posts.created', 'DESC')
			->get($count, $params->offset);
			
		return $post;
	}
	
	public function getByTag($count, $params)
	{
		$post = new stdClass();
		
		$post->count = $this
			->where_related_tag('name', $params->name)
			->order_by('posts.created', 'DESC')
			->get()->result_count();
		
		$post->row = $this
			->where_related_tag('name', $params->name)
			->order_by('posts.created', 'DESC')
			->get($count, $params->name);
		
		return $post;
	}
	
	public function getByYear($count, $params)
	{
		$post = new stdClass();
		
		$secondMonth = (int) $params->month + 1;
		$secondYear = $params->year;
		
		if ($secondMonth === 13) {
			$secondMonth = '01';
			$secondYear = ((int) $secondYear) + 1;
		}
		
		$post->count = $this
			->where_between(
				'created',
				"'" . $params->year . "-" . $params->month . "-01'",
				"'" . $secondYear . "-" . $secondMonth . "-01'"
			)
			->get()
			->result_count();
		
		$post->row = $this
			->where_between(
				'created',
				"'" . $params->year . "-" . $params->month . "-01'",
				"'" . $secondYear . "-" . $secondMonth . "-01'"
			)
			->get();
		
		return $post;
	}
	
	public function getPostPublicationDate()
	{
		$post = new stdClass();
		
		$post->row = $this
			->select("DATE_FORMAT(created, '%Y-%m') as date", FALSE)			
			->distinct()
			->get();
			
		return $post;
	}
	

}
