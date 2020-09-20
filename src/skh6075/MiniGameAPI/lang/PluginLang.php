<?php


namespace skh6075\MiniGameAPI\lang;

use skh6075\MiniGameAPI\MiniGameAPI;

class PluginLang{

    /** @var MiniGameAPI */
    private $plugin;
    
    /** @var string */
    private $lang;
    
    /** @var string[] */
    private $translates = [];
    
    /** @var string[] */
    private const SUPPORT_LANGUAGE = [
        "eng" => "§l§b[MiniGame]§r§7 ",
        "kor" => "§l§b[미니게임]§r§7 "
    ];
    
    
    public function __construct (MiniGameAPI $plugin, string $lang) {
        $this->plugin = $plugin;
        $this->lang = $lang;
    }
    
    public function init (): void{
        if (in_array ($this->lang, array_keys (self::SUPPORT_LANGUAGE))) {
            try {
                yaml_parse (file_get_contents ($this->plugin->getDataFolder () . "lang/" . $this->lang . ".yml"));
            } catch (\Exception $exception) {
                file_put_contents ($this->plugin->getDataFolder () . "lang/" . $this->lang . ".yml", yaml_emit ([ "prefix" => self::SUPPORT_LANGUAGE [$this->lang] ]));
            } finally {
                $this->translates = yaml_parse (file_get_contents ($this->plugin->getDataFolder () . "lang/" . $this->lang . ".yml"));
            }
        } else {
            $this->lang = array_keys (self::SUPPORT_LANGUAGE) [0];
            $this->init ();
        }
    }
    
    public static function translate (string $shceme, array $replace = [], bool $usePrefix = false): string{
        $format = $usePrefix ? $this->translates ["prefix"] ?? "" : "";
        $format .= $this->translates [$scheme] ?? "";
        foreach ($replace as $str1 => $str2) {
            $format = str_replace ($str1, $str2, $format);
        }
        return $format;
    }
}