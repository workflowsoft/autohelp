<?php

/**
 * JsExpression marks a string as a JavaScript expression.
 *
 * When using [[yii\helpers\Json::encode()]] to encode a value, JsonExpression objects
 * will be specially handled and encoded as a JavaScript expression instead of a string.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JsExpression
{
	/**
	 * @var string the JavaScript expression represented by this object
	 */
	public $expression;

	/**
	 * Constructor.
	 * @param string $expression the JavaScript expression represented by this object
	 * @param array $config additional configurations for this object
	 */
	public function __construct($expression)
	{
		$this->expression = $expression;
	}

	/**
	 * The PHP magic function converting an object into a string.
	 * @return string the JavaScript expression.
	 */
	public function __toString()
	{
		return $this->expression;
	}

    public static function encode($value, $options = 0)
    {
        $expressions = [];
        $value = static::processData($value, $expressions, uniqid());
        $json = json_encode($value, $options);
        return empty($expressions) ? $json : strtr($json, $expressions);
    }

    protected static function processData($data, &$expressions, $expPrefix)
    {
        if (is_object($data)) {
            if ($data instanceof JsExpression) {
                $token = "!{[$expPrefix=" . count($expressions) . ']}!';
                $expressions['"' . $token . '"'] = $data->expression;
                return $token;
            } elseif ($data instanceof \JsonSerializable) {
                $data = $data->jsonSerialize();
            }
            else {
                $data = get_object_vars($data);
            }

            if ($data === []) {
                return new \stdClass();
            }
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $data[$key] = static::processData($value, $expressions, $expPrefix);
                }
            }
        }

        return $data;
    }
}
