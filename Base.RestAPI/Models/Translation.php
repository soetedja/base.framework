<?php
namespace Base\Models;
use Phalcon\Mvc\Model;
class Translation extends BaseModel
{
    /**
     * Translation language identifier
     * @var Int
     */
    public $translation_language_id;

    /**
     * first word identifier
     * @var Int
     */
    public $first_word_id;

    /**
     * second word identifier
     * @var Int
     */
    public $second_word_id;

    /**
     * point 
     * @var Int
     */
    public $point;

    /**
     * Status identifier
     * @var Int
     */
    public $status_id;
    
    /**
     * This model is mapped to the table Translation
     */
    public function getSource() {
        return 'Translation';
    }
    
    /**
     * table relationship
     */
    public function initialize() {
        $this->hasMany('id', 'Word', 'first_word_id', array('foreignKey' => array('message' => 'Translation cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'Word', 'second_word_id', array('foreignKey' => array('message' => 'Translation cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'TranslationLanguage', 'translation_language_id', array('foreignKey' => array('message' => 'Translation cannot be deleted because it\'s used in other entity')));
        $this->belongsTo('status_id', 'Status', 'id');
    }
}
