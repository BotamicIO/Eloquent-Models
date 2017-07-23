<?php

/*
 * This file is part of Eloquent Models.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Eloquent\Models\Traits;

use RuntimeException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\McryptEncrypter;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;

trait EncryptAttributes
{
    public static function bootEncryptAttributes()
    {
        static::creating(function ($model) {
            $model = static::encryptAttributes($model);
        });

        static::created(function ($model) {
            $model = static::decryptAttributes($model);
        });

        static::read(function ($model) {
            $model = static::decryptAttributes($model);
        });

        static::updating(function ($model) {
            $model = static::encryptAttributes($model);
        });

        static::updated(function ($model) {
            $model = static::decryptAttributes($model);
        });
    }

    /**
     * @param $callback
     */
    public static function read($callback)
    {
        static::registerModelEvent('read', $callback);
    }

    /**
     * @param array $attributes
     * @param bool  $sync
     */
    public function setRawAttributes(array $attributes, $sync = false)
    {
        parent::setRawAttributes($attributes, $sync);

        $this->fireModelEvent('read');
    }

    /**
     * @param Model $model
     *
     * @return Model
     */
    protected static function encryptAttributes(Model $model)
    {
        foreach (static::getEncryptedAttributes() as $attribute) {
            try {
                $model->$attribute = static::getEncrypter()->encrypt($model->$attribute);
            } catch (EncryptException $e) {
            }
        }

        return $model;
    }

    /**
     * @param Model $model
     *
     * @return Model
     */
    protected static function decryptAttributes(Model $model)
    {
        foreach (static::getEncryptedAttributes() as $attribute) {
            try {
                if (is_string($model->$attribute)) {
                    $model->$attribute = static::getEncrypter()->decrypt($model->$attribute);
                }
            } catch (DecryptException $e) {
            }
        }

        return $model;
    }

    /**
     * @return Encrypter|McryptEncrypter
     */
    private static function getEncrypter()
    {
        $config = static::getEncrypterVariables();

        $key = $config['key'];
        $cipher = $config['cipher'];

        if (Encrypter::supported($key, $cipher)) {
            return new Encrypter($key, $cipher);
        } elseif (McryptEncrypter::supported($key, $cipher)) {
            return new McryptEncrypter($key, $cipher);
        } else {
            throw new RuntimeException('No supported encrypter found. The cipher and / or key length are invalid.');
        }
    }

    /**
     * @return array
     */
    private static function getEncrypterVariables()
    {
        $method = defined('SECURE_DOT_ENV') ? 'sec_env' : 'env';

        return [
            'key'    => $method('DB_KEY'),
            'cipher' => $method('DB_CIPHER', 'AES-256-CBC'),
        ];
    }

    /**
     * @return mixed
     */
    abstract protected function getEncryptedAttributes();
}
