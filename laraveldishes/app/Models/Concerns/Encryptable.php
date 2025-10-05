<?php
namespace App\Models\Concerns;

use Illuminate\Support\Facades\Crypt;

trait Encryptable
{
    protected function encryptableKeys(): array
    {
        return \property_exists($this, 'encryptable') ? (array) $this->encryptable : [];
    }

    public function setAttribute($key, $value)
    {
        if ($value !== null && \in_array($key, $this->encryptableKeys(), true)) {
            $value = Crypt::encryptString($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function __get($key)
    {
        $value = parent::__get($key);
        if ($value !== null && \in_array($key, $this->encryptableKeys(), true)) {
            try { return Crypt::decryptString($value); }
            catch (\Throwable) { return $value; }
        }
        return $value;
    }
}
