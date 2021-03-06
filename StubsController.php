<?php

namespace webvimark\stubsgenerator;

use yii\console\Controller;
use yii\console\Exception;

class StubsController extends Controller
{
    /**
     * You can specify multiple configs. This configs will be always will be used in stub generation.
     * For example:
     *
     * ```php
     *
     * [
     *     'console/config/main.php',
     *     'common/config/main.php',
     *     'frontend/config/main.php',
     * ]
     *
     * ```
     *
     * @var array
     */
    public $configs = [];

    public $outputFile = null;

    protected function getTemplate()
    {
        return <<<TPL
<?php

/**
 * Yii app stub file. Autogenerated by yii2-stubs-generator (stubs console command).
 * Used for enhanced IDE code autocompletion.
 * Updated on {time}
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static \$app;
}
/**{stubs}
 **/
abstract class BaseApplication extends yii\base\Application
{
}

/**{stubs}
 **/
class WebApplication extends yii\web\Application
{
}

/**{stubs}
 **/
class ConsoleApplication extends yii\console\Application
{
}
TPL;
    }

    public function actionIndex()
    {
        $path = $this->outputFile ? $this->outputFile : \Yii::$app->getVendorPath() . DIRECTORY_SEPARATOR . 'Yii.php';

        $components = [];

        $configs = array_merge($this->configs, \Yii::$app->requestedParams);

        foreach ($configs as $configPath) {
            if (!file_exists($configPath)) {
                throw new Exception('Config file doesn\'t exists: ' . $configPath);
            }

            $config = include($configPath);

            foreach ($config['components'] as $name => $component) {
                if (!isset($component['class'])) {
                    continue;
                }

                $components[$name][] = $component['class'];
            }
        }

        $stubs = '';
        foreach ($components as $name => $classes) {
            $classes = implode('|', array_unique($classes));
            $stubs .= "\n * @property {$classes} \$$name";
        }

        $content = str_replace('{stubs}', $stubs, $this->getTemplate());
        $content = str_replace('{time}', date(DATE_ISO8601), $content);

        if($content!=@file_get_contents($path)) {
            file_put_contents($path, $content);
        }
    }
}
