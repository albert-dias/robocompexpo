import FormData from 'form-data';
import urljoin from 'url-join';
// import GlobalContext from '../context';
// import { useStateLinkUnmounted } from '@hookstate/core';
import RNFetchBlob from 'rn-fetch-blob';

// const API_URL = 'http://192.168.88.72/robocompexpo/robo-api';
const API_URL = 'http://192.168.88.72/robocompexpo/api';

// const getAuthorizationHeader = () => {
//     // const authState = useStateLinkUnmounted(GlobalContext.auth.authStateRef);
//     // const headers = authState.value.token !== undefined ? {
//         // Authorization: `Bearer ${authState.value.token}`,
//     // } : undefined;

//     // return { headers };
// };

const get = async<T>(path: string): Promise<T> => {
    const url = urljoin(API_URL, path);
    const method = 'GET';
    const request = await fetch(url, { method });

    const response = await request.json();

    return response;
};

// const authGet = async<T>(path: string): Promise<T> => {
//     // const authState = useStateLinkUnmounted(GlobalContext.auth.authStateRef);
//     // const url = urljoin(API_URL, path, `?token=${authState.value.token}`);
//     const method = 'GET';
//     // const { headers } = getAuthorizationHeader();
//     // const request = await fetch(url, { method, headers });

//     // const response = await request.json();
//     // console.log(response);

//     // return response;
// };

interface BodyType<T> { [s: string]: T; }

type BodyFormData = BodyType<string | {
    uri: string;
    type: string;
    name: string;
}>;

type BodyUploadImage = {
    data: string;
    type?: string;
    name: string;
    filename?: string;
};

type BodyString = BodyType<string>;

const post = async <T>(path: string, formData?: BodyFormData): Promise<T> => {

    const body = new FormData();
    if (formData) {
        Object.keys(formData).forEach((i) => {
            body.append(i, formData[i]);
        });
    }
    const url = urljoin(API_URL, path);

    const method = 'POST';
    const request = await fetch(url, {
        method,
        body: formData && body,
    });
    console.log(request);
    const response = await request.json();

    console.log(response);
    return response;
}

export default {
    get,
    // authGet,
    post,
}