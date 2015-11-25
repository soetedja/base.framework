<?php
namespace Base\Models;
use Phalcon\Mvc\Model;
class TranslationLanguage extends Model
{
    /**
     * Identifier
     * @var Int
     */
    public $id;

    /**
     * Language identifier
     * @var Int
     */
    public $first_language_id;


    /**
     * Language identifier
     * @var Int
     */
    public $second_language_id;

    /**
     * First word language id
     * @var Int
     */
    public $first_word_language_id;

    /**
     * Description
     * @var String
     */
    public $description;

    /**
     * Statuts
     * @var Int
     */
    public $status_id;
    
    /**
     * This model is mapped to the table TranslationLanguage
     */
    public function getSource() {
        return 'TranslationLanguage';
    }
    
    /**
     * table relationship
     */
    public function initialize() {
        $this->hasMany('id', 'Language', 'first_language_id', array('foreignKey' => array('message' => 'TranslationLanguage cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'Language', 'second_language_id', array('foreignKey' => array('message' => 'TranslationLanguage cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'Language', 'first_word_language_id', array('foreignKey' => array('message' => 'TranslationLanguage cannot be deleted because it\'s used in other entity')));
        $this->belongsTo('status_id', 'Status', 'id');
    }
}
