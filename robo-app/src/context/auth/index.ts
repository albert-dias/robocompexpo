import { createStateLink } from "@hookstate/core";

export interface StateUser {
    category_id: number;
    cep: string;
    cpf: string;
    created: Date;
    email: string;
    image: string | null;
    name: string;
    number_contact: string;
    provider_id: 12;
    subcategory_id: 4;
    user_type: number;
    latitude: number;
    longitude: number;
    nickname: string;
    radius: number | null;
}

interface State {
    token?: string;
    user?: StateUser;
}

const initialLoadingRef = createStateLink(true);
const authStateRef = createStateLink<State>({});

export default {
    initialLoadingRef,
    authStateRef,
};