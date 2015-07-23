Search suggest / elasticsearch
================

## Usage

在composer.json文件中 **requird** 项中添加

```
"callwoola/searchsuggest": "dev-develop"
```

更新项目依赖
```
> composer update -v
```

在app/config/app.php中 **providers** 项中添加这一项

```
'..\Search\Provider\SearchProvider',
```

在app/config/app.php中 **aliases** 项中添加别名
```
'Search' => '..\Search\Provider\Facades\Search',
```

## Config
...


## License

for Free