<?php
/**
* Contain the CategoryNode class
* Each Node maintain its parent, children Node and informations of self.
*
* @package MediaWiki
* @author Zeng Ji(zengji@gmail.com)
*/
class CategoryInfo {
var $category_id;
var $category_name;
function __construct($categoryId, $categoryName) {
$this->category_id = $categoryId;
$this->category_name = $categoryName;
}
}
class CategoryNode {
// The data structure support:
// 1. Each category node should has only one parent or not.
// 2. Each category node could has more than one child.
var $parent;
var $children;
var $categoryInfo;
// This variable is used to guarantee: There is no loop in parent/child relationship.
// After node is added to category tree, the variable should be set to true.
// If one node's "hasTravelled" is true, it should not be processed any more.
var $hasTravelled;
function __construct($categoryId, $categoryName) {
$this->parent = false;
$this->children = false;
$this->categoryInfo = new CategoryInfo($categoryId, $categoryName);
$this->hasTravelled = false;
}
function getCategoryName() {
return $this->categoryInfo->category_name;
}
}
?>