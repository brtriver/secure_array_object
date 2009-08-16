<?php
function secure_array($arr=array())
{
  return new EscapeArrayObject($arr);
}
Class EscapeArrayObject extends ArrayObject {
  public function __construct($input=array(), $flag=self::STD_PROP_LIST, $iterator_class='EscapeArrayIterator')
  {
    parent::__construct($input, $flag, $iterator_class);
  }
  public function offsetGet($id)
  {
    $v = parent::offsetGet($id);
    if (is_array($v)) {
      array_walk_recursive($v, array($this, 'escape'));
    } else {
      self::escape($v);
    }
    return $v;
  }
  public static function escape(&$v)
  {
    if (!is_string($v)) return;
    $v = htmlspecialchars_decode($v, ENT_QUOTES);
    $v = htmlspecialchars($v, ENT_QUOTES, 'utf-8');
  }
  public function unescape($id)
  {
    return parent::offsetGet($id);
  }
}
class EscapeArrayIterator extends ArrayIterator
{
  public function current()
  {
    $v = parent::current();
    if (is_array($v)) {
      array_walk_recursive($v, array('EscapeArrayObject', 'escape'));
    } else {
      EscapeArrayObject::escape($v);
    }
    return $v;
  }
}
