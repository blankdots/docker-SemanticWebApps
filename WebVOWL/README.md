## DockerRecipe for WebVOWL

Docker recipe for WebVOWL: http://vowl.visualdataweb.org/webvowl.html

Author: http://blankdots.com

### Build Instructions

In the WebVOWL folder, after Docker has been installed and configured run separately:

```
docker build -t blankdots/webvowl .
docker images
docker run -p <dockerip>:49159:8000 -i -t blankdots/webvowl
```
> `<dockerip>` (optional) - represents IP of docker can be determined using `boot2docker ip`

In your browser go to:
```
dockerip:49159
```

Cleaning all the containers and images:
```
docker rm $(docker ps -a -q)
docker rmi $(docker images -q)
```

Using bash inside the container:
```
docker run -i -t blankdots/webvowl bash
```

Connecting to a running container:
```
docker exec <image> -it sh
```

> The `<image>` can be determine using `docker ps`
