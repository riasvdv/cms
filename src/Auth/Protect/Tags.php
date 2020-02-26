<?php

namespace Statamic\Auth\Protect;

use Illuminate\Support\ViewErrorBag;
use Statamic\Tags\Tags as BaseTags;
use Statamic\Tags\Traits\RendersForms;

class Tags extends BaseTags
{
    use RendersForms;

    protected static $handle = 'protect';

    public function passwordForm()
    {
        if (! $token = request('token')) {
            return $this->parse([
                'errors' => [],
                'no_token' => true
            ]);
        }

        $html = $this->formOpen(route('statamic.protect.password.store'));

        $html .= '<input type="hidden" name="token" value="'.$token.'" />';

        $errors = session('errors', new ViewErrorBag)->passwordProtect;

        $html .= $this->parse([
            'errors' => $errors->toArray(),
            'error' => $errors->first()
        ]);

        $html .= $this->formClose();

        return $html;
    }
}
