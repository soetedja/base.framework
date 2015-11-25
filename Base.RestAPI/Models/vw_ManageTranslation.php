<?php
namespace Base\Models;

use Phalcon\Mvc\Model;

/**
 * ManageTranslation class
 */
class vw_ManageTranslation extends BaseModel
{
    /**
     * [$indonesian_id description]
     * @var [type]
     */
    public $indonesian_id;

    /**
     * [$indonesian description]
     * @var [type]
     */
    public $indonesian;

    /**
     * [$ngoko_ids description]
     * @var [type]
     */
    public $ngoko_ids;

    /**
     * [$ngoko description]
     * @var [type]
     */
    public $ngoko;

    /**
     * [$indo_ngoko_points description]
     * @var [type]
     */
    public $indo_ngoko_points;

    /**
     * [$krama_ids description]
     * @var [type]
     */
    public $krama_ids;

    /**
     * [$krama description]
     * @var [type]
     */
    public $krama;

    /**
     * [$indo_krama_points description]
     * @var [type]
     */
    public $indo_krama_points;

    /**
     * [$kramainggil_ids description]
     * @var [type]
     */
    public $kramainggil_ids;

    /**
     * [$kramainggil description]
     * @var [type]
     */
    public $kramainggil;

    /**
     * [$indo_kramainggil_points description]
     * @var [type]
     */
    public $indo_kramainggil_points;

    /**
     * This model is mapped to the view vw_manage_translation
     */
    public function getSource() {
        return 'vw_manage_translation';
    }
    
}
