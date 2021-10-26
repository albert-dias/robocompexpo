import { RequestServices } from "../pages/Services/list";

type Request<T, messageErrorProp extends 'msg_erro' | 'message' = 'message'> = {
    status: true;
    result: T;
} | {
    status: false;
    result: {
        [S in messageErrorProp]: string;
    };
};

export default Request;