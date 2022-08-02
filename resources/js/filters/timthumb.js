export default (value,width,height,quality,crop) => {
    return `${window.Laravel.base}/images/timthumb.php?src=${value}&w=${width}&h=${height}&zc=${crop}&q=${quality}&s=0`;
}
