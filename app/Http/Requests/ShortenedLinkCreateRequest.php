<?php

namespace App\Http\Requests;

use App\Service\ShortenedLinkGenerator;
use Illuminate\Foundation\Http\FormRequest;

class ShortenedLinkCreateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'original_url' => [
                'required',
                'url',
            ],
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'original_url.url' => 'The url format is invalid.'
        ];
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $token = $this->getLinkGenerator()->generateToken($this->get('original_url'));

        return array_merge(
            [
                'token' => $token,
                'shortened_url' => $this->getLinkGenerator()->generateUrl($token),
            ],
            $this->all()
        );
    }

    /**
     * @return ShortenedLinkGenerator
     */
    protected function getLinkGenerator()
    {
        return resolve(ShortenedLinkGenerator::class);
    }
}
