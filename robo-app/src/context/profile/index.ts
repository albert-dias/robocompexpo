// Import de pacotes
import { createStateLink } from "@hookstate/core";
import FormData from "form-data";

// Import de páginas
import request from "../../util/request";
import Profile from "../../interfaces/Profile";
import editProfile from "./editProfile";
import editPassword from "./editPassword";

interface Request<T> {
    status: boolean;
    result: T;
}

const loadingImageProfileRef = createStateLink(false);
const imageProfileRef = createStateLink<string | undefined>(undefined);
const body = new FormData();

body.append('perfil', {});

const uploadImage = async (uri: string) => {
    await request.authUploadImage('Clients/uploadProfile', [{
        name: 'perfil',
        filename: 'perfil-photo.jpg',
        type: 'image/jpg',
        data: uri,
    }]);
};

const loadingProfileRef = createStateLink(true);
const profileRef = createStateLink<Profile | undefined>(undefined);
const fetchProfile = async () => {
    const loading = loadingProfileRef.access();
    loading.set(true);
    const response = await request.authPost<Request<Profile>>(
        'People/getPerfilClient',
    );
    loading.set(false);
    profileRef.access().set(response.result);
};

const fetchImageProfile = async () => {
    loadingImageProfileRef.access().set(true);
    const response = await request.authGeneric('Clients/getImageProfile');
    if (response.info().status === 200) {
        imageProfileRef.access().set(`file://${response.path()}`);
    }
    loadingImageProfileRef.access().set(false);
};

export default {
    editProfile,
    editPassword,
    fetchProfile,
    fetchImageProfile,
    imageProfileRef,
    profileRef,
    loadingImageProfileRef,
    uploadImage,
};
