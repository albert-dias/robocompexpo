import { useStateLink } from "@hookstate/core";
import GlobalContext from "../context";
import { StateUser } from "../context/auth";
import storage from "./storage";

const {
    auth: {
        initialLoadingRef,
        authStateRef
    }
} = GlobalContext;

const useToken = () => {
    const authState = useStateLink(authStateRef);
    const initialLoading = useStateLink(initialLoadingRef);

    const set = async (token: string, user: StateUser) => {
        authState.set({
            token,
            user
        });
        await Promise.all([
            storage.setToken(token),
            storage.setUser(user),
        ]);
    };

    const unset = async () => {
        await Promise.all([
            storage.remove('token'),
            storage.remove('user'),
        ]);
    };

    return {
        set,
        unset,
        initialLoading,
    };
};

export default useToken;