<?php
class sfFeedOpmlOutline extends sfOpmlOutline
{
  public function asTaggedArray($tags = array())
  {
    $array = $this->toArray();
    $result = array();

    if (count($this->outlines) == 0)
    {
      $array['tags'] = $tags;
      $result[$array['xmlUrl']] = $array;
    }
    else
    {
      $tags = array($array['title']);

      foreach ($this->outlines as $outline)
      {
        $outline_array = $outline->asTaggedArray($tags);
        $result = array_merge($result, $outline_array);
      }
    }

    return $result;
  }
}