search suggest (类似于google的搜索提示)
================
[![Packagist](https://img.shields.io/packagist/dt/callwoola/search-suggest.svg)](https://packagist.org/packages/callwoola/search-suggest)
[![Build Status](https://travis-ci.org/Callwoola/search-suggest.svg)](https://travis-ci.org/Callwoola/search-suggest)

### 功能说明
* 把句子分词后缓存转换成拼音缓存
* 把句子分词后缓存
* 当你输入英文 或者中文的时候，可以从缓存里获取匹配值返回


## 使用

code:

创建索引
```php
$suggest = new Suggest;
$result = $suggest->createIndex(['word','word2']);
```

搜索
```php
$suggest = new Suggest;
$result = $suggest->search('word');
```

## Usage

在composer.json文件中 **requird** 项中添加

```json
"Callwoola/search-suggest": "1.0.1"
```

更新项目依赖
```php
composer update -v
```

在app/config/app.php中 **providers** 项中添加这一项

```php
'Callwoola\SearchSuggest\Provider\SearchProvider',
```

在app/config/app.php中 **aliases** 项中添加别名

```php
'SearchSuggest' => 'Callwoola\SearchSuggest\Provider\Facades\Suggest',
```

## frontend
前端框架

[link](https://github.com/xdan/autocomplete)(基于jQuery的自动提示插件)

## License

for Free
