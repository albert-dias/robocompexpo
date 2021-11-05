import FormData from "form-data";
import urljoin from 'url-join';
import { useStateLinkUnmounted } from "@hookstate/core";
// import RNFetchBlob from "rn-fetch-blob";

import GlobalContext from "../context";
import auth from "../context/auth";

//EM LOCALHOST MUDAR PARA O SEU IP
const API_URL = 'https://192.168.88.71/robocompexpo/robo-api';

const getAuthorizationHeader = () => {
    const authState = useStateLinkUnmounted(GlobalContext.auth.authStateRef);
    const headers = (authState.value.token !== undefined) ? {
        Authorization: `Bearer ${authState.value.token}`
    } : undefined;

    return { headers };
};

const get = async<T>(path: string): Promise<T> => {
    const url = urljoin(API_URL, path);
    const method = 'GET';
    const request = await fetch(url, { method });

    const response = await request.json();
    console.log(response);

    return response;
};

const authGet = async<T>(path: string): Promise<T> => {
    const authState = useStateLinkUnmounted(GlobalContext.auth.authStateRef);
    const url = urljoin(API_URL, path, `?token=${authState.value.token}`);
    const method = 'GET';
    const { headers } = getAuthorizationHeader();
    const request = await fetch(url, {
        method, headers
    });

    const response = await request.json();
    console.log(response);

    return response;
};

interface BodyType<T> {
    [s: string]: T;
};

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
};

const authPost = async <T>(path: string, formData?: BodyFormData): Promise<T> => {
    const body = new FormData();
    if (formData) {
        Object.keys(formData).forEach((i) => {
            body.append(i, formData[i]);
        });
    }
    const authState = useStateLinkUnmounted(GlobalContext.auth.authStateRef);
    const url = urljoin(API_URL, path, `?token=${authState.value.token}`);
    const method = 'POST';

    const { headers } = getAuthorizationHeader();
    const request = await fetch(url, {
        method,
        body: formData && body,
        headers,
    });

    console.log(`req ${path}`, formData, request);

    const response = await request.json();

    console.log(`resp ${path}`, response);

    return response;
};

export default {
    get,
    authGet,
    post,
    authPost,
};