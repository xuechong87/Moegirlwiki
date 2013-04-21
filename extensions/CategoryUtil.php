<?php
require_once( 'CategoryTravelerBase.php' );
/**
* Utilities based on category traveler
*
* @package MediaWiki
* @author Zeng Ji(zengji@gmail.com)
*/
class CategoryUtil extends CategoryTravelerBase {
// "cNameList" is a string that could be used in IN clause of a SQL query
// An example would be: ("Categroy Name 1", "Category Name 2"...)
// "cNameList" could be get by function "getCNameList".
// "$categoryRoot" is the name of category that you want to the travel start from.
// If define "categoryRoot" in function,
// "cNameList" would be name list including category root itself and all its children categories.
// If not define "categoryRoot" in function,
// "cNameList" would be name list including all categories.
var $cNameList;
function __construct() {
parent::__construct();
}
function getCNameList($categoryRoot=false) {
parent::buildCategoryTree($categoryRoot);
parent::travelCategoryTree();
return $this->cNameList;
}
// Implementation of abstract function
function travelStart() {
$this->cNameList = "(";
}
function travelEnd() {
$this->cNameList = substr($this->cNameList, 0, strlen($this->cNameList)-1);
$this->cNameList .= ")";
}
function travelBeforeFirst($level, $categoryNode) {
}
function travelAfterLast($level, $categoryNode) {
}
function travel($level, $categoryNode) {
$categoryname = $categoryNode->getCategoryName();
$this->cNameList .= "\"" . $categoryname . "\",";
}
}
?>