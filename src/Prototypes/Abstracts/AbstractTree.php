<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/28/2019
 * Time: 6:20 PM
 */

namespace Qpdb\Common\Prototypes\Abstracts;


class AbstractTree
{

	const ID_NAME        = 'idName';
	const PARENT_ID_NAME = 'parentIdName';
	const CHILDREN_NAME  = 'childrenName';
	const DEPTH_NAME     = 'depthName';


	/**
	 * @var array
	 */
	protected $flatArray = [];

	/**
	 * @var array
	 */
	protected $treeArray = [];

	/**
	 * @var array
	 */
	protected $treeArray_u = [];

	/**
	 * @var int|string
	 */
	protected $rootValue = 0;

	/**
	 * @var int
	 */
	protected $maxDepth = -1;

	/**
	 * @var array
	 */
	protected $linearTreeArray = [];

	/**
	 * @var array
	 */
	protected $role = [
		self::ID_NAME => 'id',
		self::PARENT_ID_NAME => 'parent_id',
		self::CHILDREN_NAME => 'children',
		self::DEPTH_NAME => 'depth'
	];

	/**
	 * @var array
	 */
	protected $parents = [];


	/**
	 * Tree constructor.
	 * @param array $flatArray
	 */
	public function __construct( array $flatArray ) {
		$this->flatArray = $flatArray;
		$this->prepareFlatArray();
	}

	/**
	 * @param $idName
	 * @return $this
	 */
	public function withIdName( $idName ) {
		$this->role[ self::ID_NAME ] = $idName;

		return $this;
	}

	/**
	 * @param $parentIdName
	 * @return $this
	 */
	public function withParentIdName( $parentIdName ) {
		$this->role[ self::PARENT_ID_NAME ] = $parentIdName;

		return $this;
	}

	/**
	 * @param $childrenName
	 * @return $this
	 */
	public function withChildrenName( $childrenName ) {
		$this->role[ self::CHILDREN_NAME ] = $childrenName;

		return $this;
	}

	/**
	 * @param int $depth
	 * @return $this
	 */
	public function withMaxDepth( $depth ) {

		$this->maxDepth = $depth;

		return $this;
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function withDepthName( $name ) {
		$this->role[ self::DEPTH_NAME ] = $name;

		return $this;
	}

	/**
	 * @param int|string $value
	 * @return $this
	 */
	public function withRootValue( $value = 0 ) {
		$this->rootValue = $value;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function buildTree() {
		$this->treeArray = $this->createTree( $this->flatArray, $this->rootValue );
		$this->treeArray_u = $this->createTreeUnAssoc( $this->flatArray, $this->rootValue );
		$this->createLinearTreeArray();

		return $this;
	}

	/**
	 * @return array
	 */
	public function getTreeArray() {
		return $this->treeArray;
	}

	/**
	 * @return array
	 */
	public function getTreeArrayU() {
		return $this->treeArray_u;
	}


	/**
	 * @return array
	 */
	public function getLinearTreeArray() {
		return $this->linearTreeArray;
	}

	/**
	 * @return array
	 */
	public function getFlatArray() {
		return $this->flatArray;
	}

	/**
	 * @param mixed $nodeId
	 * @return array
	 */
	public function getChildren( $nodeId ) {
		$findChildren = array();
		foreach ( $this->flatArray as $key => $value ) {
			if ( $value[ $this->role[ self::PARENT_ID_NAME ] ] == $nodeId ) {
				$findChildren[] = $value[ $this->role[ self::ID_NAME ] ];
				$sub = $this->getChildren( $value[ $this->role[ self::ID_NAME ] ] );
				foreach ( $sub as $k => $v ) {
					$findChildren[] = $v;
				}
			}
		}

		return $findChildren;
	}

	public function getParents( $nodeId ) {
		$this->parents = [];
		$this->calculateParents( $nodeId );

		return $this->parents;
	}

	protected function calculateParents( $nodeId ) {

		if ( !array_key_exists( $this->flatArray[ $nodeId ][ $this->role[ self::PARENT_ID_NAME ] ], $this->flatArray ) )
			return false;

		$parentNode = $this->flatArray[ $nodeId ][ $this->role[ self::PARENT_ID_NAME ] ];

		if ( $parentNode != $this->rootValue )
			$this->parents[] = $parentNode;

		if ( $parentNode != $this->rootValue ) {
			$this->calculateParents( $parentNode );
		}

		return true;

	}

	protected function createTree( array $elements, $parentId = 0, $depth = 0 ) {
		$tree = array();

		foreach ( $elements as $element ) {
			if ( $element[ $this->role[ self::PARENT_ID_NAME ] ] == $parentId ) {
				if ( $this->maxDepth > -1 && $depth > $this->maxDepth )
					continue;
				$children = $this->createTree(
					$elements,
					$element[ $this->role[ self::ID_NAME ] ],
					( $depth + 1 )
				);
				$element[ $this->role[ self::DEPTH_NAME ] ] = $depth;
				if ( $children ) {
					$element[ $this->role[ self::CHILDREN_NAME ] ] = $children;
				}
				$tree[ $element[ $this->role[ self::ID_NAME ] ] ] = $element;
				unset( $elements[ $element[ $this->role[ self::ID_NAME ] ] ] );
			}
		}

		return $tree;
	}

	protected function createTreeUnAssoc( array $elements, $parentId = 0, $depth = 0 ) {
		$tree = array();

		foreach ( $elements as $element ) {
			if ( $element[ $this->role[ self::PARENT_ID_NAME ] ] == $parentId ) {
				if ( $this->maxDepth > -1 && $depth > $this->maxDepth )
					continue;
				$children = $this->createTreeUnAssoc(
					$elements,
					$element[ $this->role[ self::ID_NAME ] ],
					( $depth + 1 )
				);
				$element[ $this->role[ self::DEPTH_NAME ] ] = $depth;
				if ( $children ) {
					$element[ $this->role[ self::CHILDREN_NAME ] ] = $children;
				}
				$tree[] = $element;
				unset( $elements[ $element[ $this->role[ self::ID_NAME ] ] ] );
			}
		}

		return $tree;
	}

	/**
	 * @param null|array $tree
	 */
	protected function createLinearTreeArray( $tree = null ) {
		if ( is_null( $tree ) )
			$tree = $this->treeArray;

		foreach ( $tree as $key => $item ) {
			$this->linearTreeArray[ $key ] = $this->getStructureList( $item );
			if ( isset( $item[ $this->role[ self::CHILDREN_NAME ] ] ) ) {
				$this->createLinearTreeArray( $item[ $this->role[ self::CHILDREN_NAME ] ] );
			}
		}
	}

	protected function getStructureList( $item ) {
		unset( $item[ $this->role[ self::CHILDREN_NAME ] ] );

		return $item;
	}

	/**
	 * @return bool
	 */
	protected function prepareFlatArray() {
		if ( $this->isArrayAssoc( $this->flatArray ) )
			return true;

		$newFlat = [];

		foreach ( $this->flatArray as $value )
			$newFlat[ $value[ $this->role[ self::ID_NAME ] ] ] = $value;

		$this->flatArray = $newFlat;

		return true;
	}


	/**
	 * @param array $arr
	 * @return bool
	 */
	protected function isArrayAssoc( array $arr ) {
		if ( array() === $arr )
			return false;

		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}


}