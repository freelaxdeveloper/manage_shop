<?php


namespace App\Services;


use App\Site;

class SiteService
{
    public static $site_id;

    protected static $site;

    public function __construct()
    {
        $this->checkAndSaveSiteChanges();

        if (empty(self::$site)) {
            $this->setSite();
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function __get(string $key)
    {
        if (isset(self::$site[$key])) {
            return self::$site[$key];
        } elseif (property_exists($this, $key)) {
            return $this->{$key};
        }

        return null;
    }

    /**
     * @param int|null $site_id
     * @return SiteService
     */
    public function setSite(int $site_id = null): SiteService
    {
        $site_id = $site_id ?? $this->getId();

        if ($site_id) {
            if ($site = Site::find($site_id)){
                self::$site = $site->toArray();
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return self::$site;
    }

    /**
     * @return SiteService
     */
    protected function checkAndSaveSiteChanges(): SiteService
    {
        if (request()->has('site_id')) {
            $this->set(request()->input('site_id'));
        }

        return $this;
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
//        dd(self::$site_id);
        return self::$site_id ?? session()->get('site_id');
    }

    /**
     * @param int $site_id
     * @return SiteService
     */
    public function set(int $site_id): SiteService
    {
        if (!$site = Site::where(Site::ID, $site_id)->first()) {
            return $this;
        }

        self::$site_id = $site_id;
        self::$site = $site->toArray();
        session(['site_id' => $site_id]);

        return $this;
    }
}
