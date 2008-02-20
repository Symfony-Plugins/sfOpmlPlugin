<?php
class sfOpmlOutline
{
  protected
    $properties,
    $outlines,
    $outline_class;

  public function __construct($outline_array = array())
  {
    $this->outline_class = get_class($this);

    if ($outline_array)
    {
      $this->initialize($outline_array);
    }
    else
    {
      $this->properties = array();
    }
  }

  public function fromArray($array)
  {
    $outlines = array();
    $properties = array();
    $outline_class = $this->outline_class;

    foreach ($array['outlines'] as $outline_array)
    {
      $outline = new $outline_class();
      $outlines[] = $outline->fromArray($outline_array);
    }

    foreach ($array as $name => $value)
    {
      if ($name != 'outlines')
      {
        $properties[$name] = $value;
      }
    }

    $this->outlines = $outlines;
    $this->properties = $properties;
    return $this;
  }

  public function fromXml($xml)
  {
    $outlines = array();
    $properties = array();
    $outline_class = $this->outline_class;

    foreach ($xml->outline as $outline_xml)
    {
      $outline = new $outline_class();
      $outlines[] = $outline->fromXml($outline_xml);
    }

    foreach ($xml->attributes() as $name => $value)
    {
      $properties[$name] = (string) $value;
    }

    $this->outlines = $outlines;
    $this->properties = $properties;
    return $this;
  }

  public function getOutlines()
  {
    return $this->outlines;
  }

  public function getProperties()
  {
    return $this->properties;
  }

  public function initialize($outline_array)
  {
    $this->fromArray($outline_array);
    return $this;
  }

  public function setOutlines($outlines)
  {
    $this->outlines = $outlines;
  }

  public function setProperties($properties)
  {
    $this->properties = $properties;
  }

  public function setProperty($name, $value)
  {
    $this->properties[$name] = $value;
  }

  public function toArray()
  {
    $result = $this->properties;
    $outlines = array();

    foreach ($this->outlines as $outline)
    {
      $outlines[] = $outline->toArray();
    }

    $result['outlines'] = $outlines;
    return $result;
  }

  public function toXml()
  {
    $properties = '';

    foreach ($this->properties as $name => $value)
    {
      $properties .= sprintf(' %s="%s"', $name, $value);
    }

    if (count($this->outlines) > 0)
    {
      $xml = array();

      $xml[] = '<outline'.$properties.'>';

      foreach ($this->outlines as $outline)
      {
        $xml[] = $outline->toXml();
      }

      $xml[] = '</outline>';
      return implode("\n", $xml);
    }
    else
    {
      return '<outline'.$properties.'/>';
    }
  }
}