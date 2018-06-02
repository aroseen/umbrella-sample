<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

/**
 * Class CreateUrlRequest.
 *
 * @package App\Http\Requests
 */
class CreateUrlRequest extends FormRequest
{
    private const STATUS_AVAILABLE = 200;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'origin_url' => 'required|url',
            'short_url'  => 'required|url',
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('short_url') && $this->input('short_url') !== null) {
            $inputs              = $this->all();
            $inputs['short_url'] = Helper::getShortUrlPrefix().'/'.$inputs['short_url'];
            $this->replace($inputs);
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator $validator
     * @return void
     * @throws ValidationException
     */
    public function withValidator(Validator $validator): void
    {
        if (!$validator->fails()) {
            try {
                $response = (new Client())->get($this->input('origin_url'));
                if ($response->getStatusCode() !== static::STATUS_AVAILABLE) {
                    $this->validationFailed($validator, 'origin_url', __('home.notValidUrlErrorMessage', [
                        'attribute' => 'origin_url',
                    ]));
                }
            } catch (ClientException $exception) {
                $this->validationFailed($validator, 'origin_url', __('home.errorUrlErrorMessage', [
                    'url'    => $this->input('origin_url'),
                    'status' => $exception->getCode(),
                ]));
            } catch (ConnectException | RequestException $exception) {
                $this->validationFailed($validator, 'origin_url', $exception->getMessage());
            }
        }
    }

    /**
     * @param Validator $validator
     * @param string    $key
     * @param string    $message
     * @return void
     * @throws ValidationException
     */
    private function validationFailed(Validator $validator, string $key, string $message): void
    {
        $validator->getMessageBag()->add($key, $message);
        throw new ValidationException($validator);
    }
}
