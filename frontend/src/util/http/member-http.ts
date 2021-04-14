import HttpResource from './http-resource';
import { httpVideo } from './index';

const memberHttp = new HttpResource(httpVideo, 'cast_members');

export default memberHttp;
