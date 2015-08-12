## Image to build from sources
FROM octohost/php5

MAINTAINER XiVO Team "dev@avencall.com"

ENV HOME /root
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update -qq && \
    apt-get install --yes libjs-jquery libjs-jquery-ui libjs-underscore && \
    apt-get clean

#Install javascript deps
WORKDIR /usr/src
RUN curl -L https://github.com/xivo-pbx/xivo-lib-js/archive/master.zip -o xivo-lib-js.zip && \
    unzip xivo-lib-js.zip && \
    cd xivo-lib-js-master && \
    mkdir -p /usr/share/javascript && \
    cp -r jqplot \
        jquery-ui-timepicker \
        jquery.mousewheel \
        jquery.multiselect \
        jquery.timepicker \
        select2 \
        xivo-schedule \
        /usr/share/javascript && \
    cp -r jquery-ui-lightness/themes/ui-lightness /usr/share/javascript/jquery-ui/themes && \
    cp -r jquery-ui-lightness/css/ui-lightness /usr/share/javascript/jquery-ui/css

COPY ./src /usr/share/xivo-web-interface
COPY ./etc/xivo/web-interface /etc/xivo/web-interface
COPY ./contribs/docker/nginx-webi /etc/nginx/sites-available/default

RUN mkdir /usr/share/xivo/ && \
    echo "docker-version" > /usr/share/xivo/XIVO-VERSION && \
    ln -s /etc/xivo/web-interface/php.ini /etc/php5/fpm/conf.d/xivo.ini

WORKDIR /root

EXPOSE 80
EXPOSE 443

CMD service php5-fpm start && nginx