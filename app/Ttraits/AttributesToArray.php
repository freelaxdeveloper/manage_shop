<?php


namespace App\Ttraits;


trait AttributesToArray
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = get_object_vars($this);
        $methods = get_class_methods(self::class);

        foreach ($methods as $method) {
            if (strpos($method, 'get') !== false) {
                $key = lcfirst(str_replace('get', '', $method));

                if (isset($data[$key])) {
                    continue;
                }

                $data[$key] = $this->{$method}();
            }
        }

        return $data;
    }

}
