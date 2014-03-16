<?php namespace Ollieread\Reptile;

use Ollieread\Reptile\Facades\Reptile;

class Response
{

    protected $data = [];

    protected $pagination = [];

    protected $links = [];

    protected $meta = [];

    public function __toString()
    {
        return json_encode(array_merge(
            [
                'status'    => 'success',
                'links'     => $this->links,
                'meta'      => $this->meta
            ],
            $this->data
        ));
    }

    public function add($name, array $data, $pagination = null)
    {
        $this->data[$name] = $data;

        if(!is_null($pagination)) {
            $this->pagination[$name] = $pagination;
        }

        return $this;
    }

    public function paginate($name, $pagination)
    {
        $this->pagination[$name] = $pagination;

        if($pagination->getLastPage() > 1) {
            $links = [];

            if($pagination->getCurrentPage() > 1) {
                $this->link($name, 'previous', $pagination->getUrl($pagination->getCurrentPage() -1) . '&count=' . Reptile::request()->count());
            }
            if($pagination->getCurrentPage() < $pagination->getLastPage()) {
                $this->link($name, 'next', $pagination->getUrl($pagination->getCurrentPage() + 1) . '&count=' . Reptile::request()->count());
            }

            $this->meta($name, 'count', $pagination->count());
            $this->meta($name, 'pages', $pagination->getLastPage());
            $this->meta($name, 'total', $pagination->getTotal());
        }

        return $this;
    }

    public function link($name, $subname, $link)
    {
        $this->links[$name][$subname] = $link;

        return $this;
    }

    public function meta($name, $subname, $meta)
    {
        $this->meta[$name][$subname] = $meta;

        return $this;
    }

}