<?php
namespace bl\emailTemplates\data;

/**
 * Model of email template
 *
 * @property string $subject
 * @property string $body
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-email-templates
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class Template
{
    /**
     * @var string Subject of email
     */
    private $subject;

    /**
     * @var string Body of email
     */
    private $body;

    /**
     * Getter for `subject`
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Getter for `body`
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Template constructor
     *
     * @param string $subject
     * @param string $body
     */
    public function __construct($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Parsing of email subject
     *
     * @param array $params of example
     * ```php
     * [
     *     '{link}' => 'https://github.com/black-lamp/yii2-email-templates'
     * ]
     * ```
     */
    public function parseSubject($params)
    {
        $this->subject = self::parseTemplate($this->subject, $params);
    }

    /**
     * Parsing of email body
     *
     * @param array $params of example
     * ```php
     * [
     *     '{link}' => 'https://github.com/black-lamp/yii2-email-templates',
     *      '{author}' => Yii::$app->user->email
     * ]
     * ```
     */
    public function parseBody($params)
    {
        $this->body = self::parseTemplate($this->body, $params);
    }


    /**
     * Parsing of template field
     *
     * @param array $subject_params
     * @param array $body_params
     * Array example
     * ```php
     * [
     *     '{link}' => 'https://github.com/black-lamp/yii2-email-templates',
     *      '{author}' => Yii::$app->user->email
     * ]
     * ```
     */
    public function parse($subject_params, $body_params)
    {
        $this->parseSubject($subject_params);
        $this->parseBody($body_params);
    }

    /**
     * Method for parsing string
     *
     * @param string $source Source string for parsing
     * @param array $params of example
     * ```php
     * [
     *     '{link}' => 'https://github.com/black-lamp/yii2-email-templates',
     *      '{author}' => Yii::$app->user->email
     * ]
     * ```
     * @return string
     */
    public static function parseTemplate($source, $params)
    {
        return strtr($source, $params);
    }
}