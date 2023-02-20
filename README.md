## 《手把手教你落地 DDD》@极客时间@钟敬老师-卷卷通项目

### 执行单元测试
```shell
$ composer test
```

若本地无 PHP 环境，也可基于 Docker 执行单元测试 
```shell
$ docker build -t ddd . -f docker/Dockerfile && docker run --rm ddd composer test
```
