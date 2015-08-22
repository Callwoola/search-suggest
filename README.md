Search suggest / elasticsearch
================
[![Packagist](https://img.shields.io/packagist/dt/callwoola/searchsuggest.svg)](https://packagist.org/packages/callwoola/searchsuggest)

### 功能说明
* 把句子分词后缓存转换成拼音缓存
* 把句子分词后缓存
* 当你输入英文 或者中文的时候，可以从缓存里获取匹配值返回

## Usage

在composer.json文件中 **requird** 项中添加

```json
"callwoola/searchsuggest": "dev-develop"
```

更新项目依赖
```php
composer update -v
```

在app/config/app.php中 **providers** 项中添加这一项

```php
'..\Search\Provider\SearchProvider',
```

在app/config/app.php中 **aliases** 项中添加别名

```php
'SearchSuggest' => '..\Search\Provider\Facades\Search',
```

## Config
...


## License

for Free
