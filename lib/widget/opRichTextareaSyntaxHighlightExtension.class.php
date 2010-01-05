<?php

/**
 * opRichTextareaSyntaxHighlightPlugin
 *
 * LICENSE
 *
 * This source file is subject to the Apache License version 2.0
 * that is bundled with this package in the file LICENSE.
 *
 * @copyright  Copyright (c) 2010 Rimpei Ogawa <ogawa@tejimaya.com>
 * @license    Apache License 2.0
 */

/**
 * opRichTextareaSyntaxHighlightExtension
 *
 * @package    opRichTextareaSyntaxHighlightPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opRichTextareaSyntaxHighlightExtension extends opWidgetFormRichTextareaOpenPNEExtension
{
  static protected $isLoaded = false;

  static protected $brushAliases = array(
    'as3'           => 'AS3',
    'acrionscript3' => 'AS3',
    'bash'          => 'Bash',
    'shell'         => 'Bash',
    'c-sharp'       => 'CSharp',
    'csharp'        => 'CSharp',
    'cpp'           => 'Cpp',
    'c'             => 'Cpp',
    'css'           => 'Css',
    'delphi'        => 'Delphi',
    'pas'           => 'Delphi',
    'pascal'        => 'Delphi',
    'diff'          => 'Diff',
    'patch'         => 'Diff',
    'groovy'        => 'Groovy',
    'js'            => 'JScript',
    'jscript'       => 'JScript',
    'javascript'    => 'JScript',
    'java'          => 'Java',
    'jfx'           => 'JavaFX',
    'javafx'        => 'JavaFX',
    'perl'          => 'Perl',
    'pl'            => 'Perl',
    'php'           => 'Php',
    'plain'         => 'Plain',
    'text'          => 'Plain',
    'ps'            => 'PowerShell',
    'powershell'    => 'PowerShell',
    'py'            => 'Python',
    'python'        => 'Python',
    'rails'         => 'Ruby',
    'ror'           => 'Ruby',
    'ruby'          => 'Ruby',
    'scala'         => 'Scala',
    'sql'           => 'Sql',
    'vb'            => 'Vb',
    'vbnet'         => 'Vb',
    'xml'           => 'Xml',
    'xhtml'         => 'Xml',
    'xslt'          => 'Xml',
    'html'          => 'Xml',
  );

  static public function configure(&$configs)
  {
    self::addJavascript('js/tiny_mce/decoration');
  }

  static public function getPlugins()
  {
    return array('opSyntaxHighlight' => javascript_path('/opRichTextareaSyntaxHighlightPlugin/js/tiny_mce/editor_plugin'));
  }

  static public function getButtons()
  {
    return array(
      'op_source' => array(
        'caption' => 'Source code',
        'imageURL' => image_path('/opRichTextareaSyntaxHighlightPlugin/images/deco_op_source.gif'),
      ));
  }

  static public function getButtonOnClickActions()
  {
    return array('op_source' => 'op_mce_insert_tagname_block("%id%", "op:source", \' lang=""\');');
  }

  static public function getConvertCallbacks()
  {
    return array('op:source' => array(__CLASS__, 'toHtml'));
  }

  static public function toHtml($isEndtag, $tagname, $attributes, $isUseStylesheet)
  {
    if (!$isUseStylesheet)
    {
      return '';
    }

    if (!self::$isLoaded)
    {
      self::load();
      self::$isLoaded = true;
    }

    if (!$isEndtag)
    {
      $lang = 'plain';
      if (isset($attributes['lang']) && isset(self::$brushAliases[$attributes['lang']]))
      {
        $lang = $attributes['lang'];
      }
      self::loadBrush($lang);

      return sprintf('<pre class="brush: %s">', $lang);
    }
    else
    {
      return '</pre>';
    }
  }

  static protected function load()
  {
    self::addJavascript('syntaxhighlighter/src/shCore');
    self::addJavascript('js/init');
    self::addStylesheet('syntaxhighlighter/styles/shCore');
    self::addStylesheet('syntaxhighlighter/styles/shThemeDefault');
  }

  static protected function loadBrush($alias)
  {
    self::addJavascript('syntaxhighlighter/scripts/shBrush'.self::$brushAliases[$alias]);
  }

  static protected function addJavascript($path)
  {
    sfContext::getInstance()->getResponse()->addJavascript('/opRichTextareaSyntaxHighlightPlugin/'.$path);
  }

  static protected function addStylesheet($path)
  {
    sfContext::getInstance()->getResponse()->addStylesheet('/opRichTextareaSyntaxHighlightPlugin/'.$path);
  }
}
