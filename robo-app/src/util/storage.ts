import AsyncStorage from '@react-native-async-storage/async-storage';
import { StateUser } from "../context/auth";

interface Storage {
    token?: string;
    user?: StateUser;
}

const setToken = async (token: string) => AsyncStorage.setItem('token', token);

const setUser = async (user: StateUser) => {
    try {
        const stringfiedUser = JSON.stringify(user);
        if (stringfiedUser) {
            await AsyncStorage.setItem('user', stringfiedUser);
        }
    } catch (e) {
        console.log(e);
    }
    return null;
}

const remove = (key: keyof Storage) => AsyncStorage.removeItem(key);

const getToken = async () => AsyncStorage.getItem('token');

const getUser = async () => {
    try {
        const parsed = JSON.parse(await AsyncStorage.getItem('user') ?? 'null') as StateUser;
        return parsed as StateUser;
    } catch (e) {
        console.log(e);
        return null;
    }
};

export default {
    setToken,
    setUser,
    remove,
    getToken,
    getUser,
};
