## Description ##

TNT DVB-T for Selestat, France (October 2014)


## Scan with w_scan ##

```
w_scan -ft -c FR -L > vlc.xspf
```

## Scan with dvbv5-scan

```
sudo aptitude install dvb-tools
```

or

```
git clone git://linuxtv.org/v4l-utils.git
sudo aptitude install autoconf libtool
autoreconf -vfi
./configure
make
cd utils/dvb
./dvbv5-scan channel.txt -o output.txt
```

## Links ##

* [w_scan](http://wirbel.htpc-forum.de/w_scan/index2.html)
* [Avermedia A850 latest firmware](http://palosaari.fi/linux/v4l-dvb/firmware/af9015/)
