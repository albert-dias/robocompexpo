import { createStateLink } from "@hookstate/core";
import FormData from "form-data";

import request from "../../util/request";
import editProfile from "./editProfile";
import editPassword from "./editPassword";
import Profile from "../../interfaces/Profile";

interface Request<T> {
    status: boolean;
    result: T;
}

const loadingImageProfileRef = createStateLink(false);
const imageProfileRef = createStateLink<string | undefined>(undefined);
const body = new FormData();

body.append('perfil', {});

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

export default {
    editProfile,
    editPassword,
    fetchProfile,
    imageProfileRef,
    profileRef,
    loadingImageProfileRef,
};