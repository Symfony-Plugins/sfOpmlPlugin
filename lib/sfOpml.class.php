<?php
class sfOpml
{
  protected
    $dateCreated,
    $dateModified,
    $expansionState,
    $outline_class,
    $outlines,
    $ownerEmail,
    $ownerName,
    $title,
    $vertScrollState,
    $windowBottom,
    $windowLeft,
    $windowRight,
    $windowTop;

  public function __construct($opml_array = null)
  {
    if ((get_class($this) != __CLASS__)
        && class_exists(sprintf('%sOutline', get_class($this))))
    {
      $this->outline_class = sprintf('%sOutline', get_class($this));
    }
    else
    {
      $this->outline_class = 'sfOpmlOutline';
    }

    if ($opml_array)
    {
      $this->initialize($opml_array);
    }
  }

  public function addOutlineFromArray($outline_array)
  {
    $outline_class = $this->outline_class;
    $this->outlines[] = new $outline_class($outline_array);

    return $this;
  }

  public function asXml()
  {
    $this->initContext();
    $this->context->getResponse()->setContentType('application/xml');

    return $this->toXml();
  }

  public function fromArray($opml_array)
  {
    $this->dateCreated = isset($opml_array['dateCreated']) ? $opml_array['dateCreated'] : null;
    $this->dateModified = isset($opml_array['dateModified']) ? $opml_array['dateModified'] : null;
    $this->expansionState = isset($opml_array['expansionState']) ? $opml_array['expansionState'] : null;
    $this->ownerEmail = isset($opml_array['ownerEmail']) ? $opml_array['ownerEmail'] : null;
    $this->ownerName = isset($opml_array['ownerName']) ? $opml_array['ownerName'] : null;
    $this->title = isset($opml_array['title']) ? $opml_array['title'] : null;
    $this->vertScrollState = isset($opml_array['vertScrollState']) ? $opml_array['vertScrollState'] : null;
    $this->windowBottom = isset($opml_array['windowBottom']) ? $opml_array['windowBottom'] : null;
    $this->windowLeft = isset($opml_array['windowLeft']) ? $opml_array['windowLeft'] : null;
    $this->windowRight = isset($opml_array['windowRight']) ? $opml_array['windowRight'] : null;
    $this->windowTop = isset($opml_array['windowTop']) ? $opml_array['windowTop'] : null;
    $outlines = array();

    if (isset($opml_array['outlines']))
    {
      $outline_class = $this->outline_class;

      foreach ($opml_array['outlines'] as $outline_array)
      {
        $outline = new $outline_class();
        $outlines[] = $outline->fromArray($outline_array);
      }
    }

    $this->outlines = $outlines;
    return $this;
  }

  public function fromXml($xml)
  {
    preg_match('/^<\?xml\s*version="1\.0"\s*encoding="(.*?)\"\s*\?>$/mi', $xml, $matches);

    if (isset($matches[1]))
    {
      $this->setEncoding($matches[1]);
    }

    $xml = simplexml_load_string($xml);

    if (!$xml)
    {
      throw new Exception('Error creating feed from XML: string is not well-formatted XML');
    }

    $this->dateCreated = isset($xml->head->dateCreated) ? (string) $xml->head->dateCreated : null;
    $this->dateModified = isset($xml->head->dateModified) ? (string) $xml->head->dateModified : null;
    $this->expansionState = isset($xml->head->expansionState) ? (string) $xml->head->expansionState : null;
    $this->ownerEmail = isset($xml->head->ownerEmail) ? (string) $xml->head->ownerEmail : null;
    $this->ownerName = isset($xml->head->ownerName) ? (string) $xml->head->ownerName : null;
    $this->title = isset($xml->head->title) ? (string) $xml->head->title : null;
    $this->vertScrollState = isset($xml->head->vertScrollState) ? (string) $xml->head->vertScrollState : null;
    $this->windowBottom = isset($xml->head->windowBottom) ? (string) $xml->head->windowBottom : null;
    $this->windowLeft = isset($xml->head->windowLeft) ? (string) $xml->head->windowLeft : null;
    $this->windowRight = isset($xml->head->windowRight) ? (string) $xml->head->windowRight : null;
    $this->windowTop = isset($xml->head->windowTop) ? (string) $xml->head->windowTop : null;
    $outlines = array();

    if (isset($xml->body->outline))
    {
      $outline_class = $this->outline_class;

      foreach ($xml->body->outline as $outline_xml)
      {
        $outline = new $outline_class();
        $outlines[] = $outline->fromXml($outline_xml);
      }
    }

    $this->outlines = $outlines;
    return $this;
  }

  public function getDateCreated()
  {
    return $this->dateCreated;
  }

  public function getDateModified()
  {
    return $this->dateModified;
  }

  public function getEncoding()
  {
    return isset($this->encoding) ? $this->encoding : 'utf8';
  }

  public function getExpansionState()
  {
    return $this->expansionState;
  }

  public function getOutlines()
  {
    return $this->outlines;
  }

  public function getOwnerEmail()
  {
    return $this->ownerEmail;
  }

  public function getOwnername()
  {
    return $this->ownerName;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getVertScrollState()
  {
    return $this->vertScrollState;
  }

  public function getWindowBottom()
  {
    return $this->windowBottom;
  }

  public function getWindowLeft()
  {
    return $this->windowLeft;
  }

  public function getWindowRight()
  {
    return $this->windowRight;
  }

  public function getWindowTop()
  {
    return $this->windowTop;
  }

  protected function initContext()
  {
    if (!isset($this->context))
    {
      $this->context = sfContext::getInstance();
    }
  }

  public function initialize($opml_array)
  {
    $this->fromArray($opml_array);
    return $this;
  }

  public function setDateCreated($date_created)
  {
    $this->date_created = $date_created;
  }

  public function setDateModified($date_modified)
  {
    $this->date_modified = $date_modified;
  }

  public function setEncoding($encoding)
  {
    $this->encoding = $encoding;
  }

  public function setOutlines($outlines)
  {
    $this->outlines = $outlines;
  }

  public function setOwnerEmail($owner_email)
  {
    $this->owner_email = $owner_email;
  }

  public function setOwnerName($owner_name)
  {
    $this->owner_name = $owner_name;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function toArray()
  {
    $result = array();
    $outlines = array();

    foreach (array('dateCreated',
                   'dateModified',
                   'expansionState',
                   'ownerEmail',
                   'ownerName',
                   'title',
                   'vertScrollState',
                   'windowBottom',
                   'windowLeft',
                   'windowRight',
                   'windowTop') as $property)
    {
      if ($this->$property !== null)
      {
        $result[$property] = $this->$property;
      }
    }

    foreach ($this->outlines as $outline)
    {
      $outlines[] = $outline->toArray();
    }

    $result['outlines'] = $outlines;
    return $result;
  }

  public function toXml()
  {
    $this->initContext();
    $xml = array();
    $xml[] = '<?xml version="1.0" encoding="'.$this->getEncoding().'" ?>';
    $xml[] = '<opml version="1.0">';
    $xml[] = '  <head>';

    foreach (array('dateCreated',
                   'dateModified',
                   'expansionState',
                   'ownerEmail',
                   'ownerName',
                   'title',
                   'vertScrollState',
                   'windowBottom',
                   'windowLeft',
                   'windowRight',
                   'windowTop') as $property)
    {
      if ($this->$property !== null)
      {
        $xml[] = '    <'.$property.'>'.$this->$property.'</'.$property.'>';
      }
    }

    $xml[] = '  </head>';
    $xml[] = '  <body>';

    foreach ($this->outlines as $outline)
    {
      $xml[] = $outline->toXml();
    }

    $xml[] = '  </body>';
    $xml[] = '</opml>';

    return implode("\n", $xml);
  }
}