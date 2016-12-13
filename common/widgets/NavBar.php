<?php
/**
 * @author: huydq@vivas.vn
 */

namespace common\widgets;

use Yii;
use yii\bootstrap\BootstrapPluginAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the [[begin()]] and [[end()]] calls of NavBar
 * is treated as the content of the navbar. You may use widgets such as [[Nav]]
 * or [[\yii\widgets\Menu]] to build up such content. For example,
 *
 * ```php
 * use yii\bootstrap\NavBar;
 * use yii\widgets\Menu;
 *
 * NavBar::begin(['brandLabel' => 'NavBar Test']);
 * echo Nav::widget([
 *     'items' => [
 *         ['label' => 'Home', 'url' => ['/site/index']],
 *         ['label' => 'About', 'url' => ['/site/about']],
 *     ],
 * ]);
 * NavBar::end();
 * ```
 *
 * @see http://getbootstrap.com/components/#navbar
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class NavBar extends Widget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var bool
     */
    public $renderContainer = true;
    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $containerOptions = [];
    /**
     * @var string|boolean the text of the brand of false if it's not used. Note that this is not HTML-encoded.
     * @see http://getbootstrap.com/components/#navbar
     */
    public $brandLabel = false;
    /**
     * @param array|string|boolean $url the URL for the brand's hyperlink tag. This parameter will be processed by [[Url::to()]]
     * and will be used for the "href" attribute of the brand link. Default value is false that means
     * [[\yii\web\Application::homeUrl]] will be used.
     */
    public $brandUrl = false;
    public $toggleBtn = true;
    /**
     * @var array the HTML attributes of the brand link.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $brandOptions = [];
    /**
     * @var string text to show for screen readers for the button to toggle the navbar.
     */
    public $screenReaderToggleText = 'Toggle navigation';
    /**
     * @var boolean whether the navbar content should be included in an inner div container which by default
     * adds left and right padding. Set this to false for a 100% width navbar.
     */
    public $renderInnerContainer = true;

    /**
     * @var array the HTML attributes of the inner container.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $innerContainerOptions = [];

    public $leftContent = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
//        Html::addCssClass($this->options, 'navbar');
        if ($this->options['class'] === 'navbar') {
            Html::addCssClass($this->options, 'navbar-default');
        }
//        Html::addCssClass($this->brandOptions, 'navbar-brand');
        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::beginTag($tag, $options);
        if ($this->renderInnerContainer) {
            if (!isset($this->innerContainerOptions['class'])) {
                Html::addCssClass($this->innerContainerOptions, 'container');
            }
            echo Html::beginTag('div', $this->innerContainerOptions);
        }
        if ($this->brandLabel !== false) {
            echo Html::beginTag('div', $this->brandOptions);
//            Html::addCssClass($this->brandOptions, 'navbar-brand');
            echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl);
            echo Html::endTag('div');
        }

        if($this->toggleBtn){
            echo $this->renderToggleButton();
        }

        if($this->renderContainer){
            if(!isset($this->containerOptions['class'])){
                Html::addCssClass($this->containerOptions, 'collapse');
                Html::addCssClass($this->containerOptions, 'navbar-collapse');
            }
            $options = $this->containerOptions;
            $tag = ArrayHelper::remove($options, 'tag', 'div');
            echo Html::beginTag($tag, $options);
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
//        echo Html::endTag($tag);
        if(!empty($this->leftContent)){
            echo Html::beginTag('div', ['class' => 'top-menu']);
            echo $this->leftContent;
            echo Html::endTag('div');
        }
        if($this->renderContainer){
            echo Html::endTag('div');
        }

        if ($this->renderInnerContainer) {
            echo Html::endTag('div');
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        echo Html::endTag($tag, $this->options);
        BootstrapPluginAsset::register($this->getView());
    }

    /**
     * Renders collapsible toggle button.
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton()
    {
        return Html::a('', 'javascript:;', [
            'class' => 'menu-toggler responsive-toggler',
            'data-toggle' => 'collapse',
            'data-target' => ".navbar-collapse",
        ]);
    }
}
