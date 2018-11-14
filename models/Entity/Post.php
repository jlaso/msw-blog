<?php

namespace JLaso\Blog\models\Entity;

use app\models\core\BaseModel;
use app\models\core\SluggableInterface;
use app\models\core\ValidableInterface;
use lib\MyFunctions;
use Validate;

/**
 * Class that stores articles of this web
 */
class Post
    extends BaseModel
    implements SluggableInterface, ValidableInterface
{

    /**
     * Checks that slug not exists
     *
     * @param string $slug
     * @param int $id
     * @return bool
     */
    public static function checkSlug($slug, $id = 0)
    {
        $count = self::factory()
                    ->where('slug',$slug)
                    ->where_not_equal('id',$id)
                    ->count();

        return $count > 0;
    }

    /**
     * Validates the info
     *
     * @return array
     */
    public function validate()
    {
        $result = array();
        if(empty($this->slug)) $this->slug = $this->title;
        $this->slug = \lib\MyFunctions::slug($this->slug);
        if (empty($this->slug)) {
            $result['slug'] = Validate::cantLeaveBlank(_('Slug'));
        } else {
            $slugExists = self::checkSlug($this->slug,$this->id);
            if ($slugExists) {
                $result['slug'] = _('Repeated slug');
            }
        }
        if (empty($this->title)) {
            $result['title'] = Validate::cantLeaveBlank(_('Title'));
        }
        if (empty($this->description)) {
            $result['description'] = Validate::cantLeaveBlank(_('Description'));
        }

        return $result;
    }

    /**
     * Get the SQL creation sentece of this table
     *
     * @param array $options
     * @return string
     */
    public static function _creationSchema(Array $options = array())
    {
        $class = self::_tableNameForClass(get_called_class());

        // default options
        $options = array_merge(self::_defaultCreateOptions(),$options);

        return

            <<<EOD

CREATE TABLE IF NOT EXISTS `{$class}` (
  `id`          bigint(11) NOT NULL AUTO_INCREMENT,
  `slug`        varchar(100) NOT NULL,
  `title`       varchar(100) NOT NULL,
  `content`     text NOT NULL,
  `created_at`  datetime DEFAULT NULL,
  `updated_at`  datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }



}
