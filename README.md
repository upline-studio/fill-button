# Fill button

Button for filling some form fields using values of other fields in laravel nova resource forms. 

## Example

```php
use Upline\FillButton;

FillButton::make('Fill total fields', 'fill-prices')
    ->setFillFunction(function ($data) {
        return [
            'total' => $data['price'] + $data['quantity'],
            'totalDiscount' => $data['discount'] + $data['quantity'],
        ];
    })
    ->setSourceFields(['price', 'discount', 'quantity'])
```

### Explanation

`->setSourceFields($fields)` method sets fields that will be watched for changes, and will be sent on the button click.

`->setFillFunction(...)` method sets a function that will be called to calculate values to fill the fields.


### To be done

* Add image/video of component to readme
* Test on nova 4
* Add tests