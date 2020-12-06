<?php

namespace App;

use App\Repositories\ThemeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends ModelDb
{
    use SoftDeletes;

    const MAX_THEME = 15;
    const NAME = 'name';
    const ICON = 'icon';
    const ISVISIBLE = 'is_visible';
    const LEVEL = 'level';
    const THEME_PARENT = 'theme_parent';
    const ID = 'id';
    const CLASS_CSS = 'class_css';
    protected $dateFormat = 'U';
    protected $fillable = [];

    protected $level;
    protected $icon;
    protected $is_visible;
    protected $theme_parent;
    protected $id;
    protected $childs;


    protected $attributes = [];




    /**
     * The videos that belong to the theme.
     */
    public function videos()
    {
        return $this
            ->belongsToMany(Video::class, 'theme_video')
            ->using(ThemeVideo::class)
            ->as('themeVideo')
            ->withPivot('order')
            ->orderBy('theme_video.order', 'asc');

    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->setData(self::ID, $id);
    }
    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->_get(self::NAME);
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @return mixed
     */
    public function getIcon(): string
    {
        return $this->_get(self::ICON);
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon): void
    {
        $this->setData(self::ICON, $icon);
    }

    /**
     * @return mixed
     */
    public function getIsVisible(): int
    {
        return $this->_get(self::ISVISIBLE);
    }

    /**
     * @param mixed $is_visible
     */
    public function setIsVisible($is_visible): void
    {
       $this->setData(self::ISVISIBLE, $is_visible);
    }


    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->_get(self::LEVEL);
    }

    public function setLevel($level): void
    {
        $this->setData(self::LEVEL, $level);
    }

    /**
     * @return mixed
     */
    public function getThemeParent()
    {
        return $this->_get(self::THEME_PARENT);
    }

    /**
     * @param mixed $theme_parent
     */
    public function setThemeParent($theme_parent): void
    {
        $this->setData(self::THEME_PARENT, $theme_parent);
    }

    /**
     * @return mixed
     */
    public function getClassCss()
    {
        return $this->_get(self::CLASS_CSS);
    }

    /**
     * @param mixed $theme_parent
     */
    public function setClassCss($class_css): void
    {
        $this->setData(self::CLASS_CSS, $class_css );
    }


    public function getItems()
    {
        if(empty($this->_get('items'))){
            $this->setItems(ThemeRepository::findThemesByParent($this->getId()));
        }
        return $this->_get('items');
    }

    public function setItems($items)
    {
        $this->setData('items',$items);
    }


}
