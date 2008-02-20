<?php
class sfFeedOpml extends sfOpml
{
  public function toTaggedOutlinesArray()
  {
    $tagged_outlines = array();

    foreach ($this->outlines as $outline)
    {
      $props = $outline->getProperties();
      $outline = $outline->asTaggedArray();

      foreach ($outline as $url => $tagged_outline)
      {
        if (isset($tagged_outlines[$url]))
        {
          $former_tags = $tagged_outlines[$url]['tags'];
          $tagged_outlines[$url]['tags'] = array_merge($former_tags, $tagged_outline['tags']);
        }
        else
        {
          $tagged_outlines[$url] = $tagged_outline;
        }
      }
    }

    $array = $this->toArray();
    $array['outlines'] = $tagged_outlines;
    return $array;
  }
}