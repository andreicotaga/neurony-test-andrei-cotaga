<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/20/2019
 * Time: 12:24 AM
 */
namespace App\Repositories;

use App\Contracts\SearchableContract;
use App\Traits\NotifiesPostSearches;
use Illuminate\Database\Eloquent\Collection;
use App\Post;

class ElasticsearchPostSearchRepository implements SearchableContract
{
    use NotifiesPostSearches {
        sendNewPostSearchNotifications as protected sendNewPostSearchNotificationsTrait;
    }

    protected $posts;
    protected $keyword;

    /**
     * Search method
     * @param null|string $keyword
     * @return SearchableContract
     */
    public function search(?string $keyword): SearchableContract
    {
        if(isset($keyword))
        {
            $this->keyword = $keyword;

            $this->posts = Post::search($keyword)->get();
        }

        return $this;
    }

    /**
     * @return SearchableContract
     */
    public function active(): SearchableContract
    {
        $this->getActiveOrInactive(true);

        return $this;
    }

    /**
     * @return SearchableContract
     */
    public function inactive(): SearchableContract
    {
        $this->getActiveOrInactive(false);

        return $this;
    }

    /**
     * @return SearchableContract
     */
    public function alphabetically(): SearchableContract
    {
        if(isset($this->keyword))
        {
            $this->posts = Post::search($this->keyword)->orderBy('name')->get();
        }
        else
        {
            $this->posts = Post::search('*')->orderBy('name')->get();
        }

        return $this;
    }

    /**
     * @return SearchableContract
     */
    public function latest(): SearchableContract
    {
        if(isset($this->keyword))
        {
            $this->posts = Post::search($this->keyword)->orderBy('created_at', 'DESC')->get();
        }
        else
        {
            $this->posts = Post::search('*')->orderBy('created_at', 'DESC')->get();
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function fetch(): Collection
    {
        if(empty($this->posts))
        {
            $this->posts = Post::all();
        }

        $this->sendNewPostSearchNotifications();

        return $this->posts;
    }

    /**
     * @return string
     */
    public function sendNewPostSearchNotifications(): string
    {
        $this->sendNewPostSearchNotificationsTrait($this->posts);

        return '';
    }

    /**
     * Check if needed active or not
     * @param $param
     */
    public function getActiveOrInactive($param)
    {
        if(isset($this->keyword))
        {
            $this->posts = Post::search($this->keyword)->where('active', $param)->get();
        }
        else
        {
            $this->posts = Post::search('*')->where('active', $param)->get();
        }
    }
}