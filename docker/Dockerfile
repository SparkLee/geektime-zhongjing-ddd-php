FROM php:8.2.3-cli-alpine

# 配置 composer 环境
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer
COPY ./docker/config.json /tmp/composer/config.json
ENV COMPOSER_HOME=/tmp/composer

# 拷贝 php 源代码
WORKDIR /app
COPY . /app
COPY ./docker/.env.testing /app/.env

# 安装 composer 依赖
RUN composer install

# 创建数据库表结构
RUN composer migrate

# 执行测试
RUN composer run test
