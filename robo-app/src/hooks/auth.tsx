import React, { createContext, useCallback, useState, useContext, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import api from '../services/api';
import { Alert } from 'react-native';
// import smstk from '../services/smstoken';

interface User {
  id: string;                 //table users
  user_type_id: number;        //table users
  person_id?: number;         //table users
  active: boolean;            //table users
  name: string;               //table users
  nickname?: string;          //table users
  email: string;              //table users
  plan_id?: number;           //table users
  cpf: number;                //table users
  phone?: string;             //table people
  photo?: string;             //table users     //falta fazer upload de imagens funcionar
  date_of_birth?: Date;       //table people
  address: string             //table people
  number: number;             //table people
  district: string;           //table people
  complement?: string         //table people
  city: string                //table people
  state: string               //table people
  cep: number                 //table people
}

interface AuthState {
  token: string;
  user: User;
}

interface SignInCredentials {
  cpf: string;
  password: string;
}

interface SMSTKProps {
  checked: boolean;
  situacao: string;
}

interface AuthContextData {
  user: User;
  loading: boolean;
  signIn(credentials: SignInCredentials): Promise<void>;
  signOut(): void;
  updateUser(user: User): Promise<void>;
  // handleVerify(phone: string): Promise<void>;
  // handleCheck(phone: string, code: string): Promise<SMSTKProps>;
}

const AuthContext = createContext<AuthContextData>({} as AuthContextData);

const AuthProvider: React.FC = ({ children }) => {
  const [data, setData] = useState<AuthState>({} as AuthState);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadStorageData(): Promise<void> {

      const [token, user] = await AsyncStorage.multiGet([
        '@Robocomp:token',
        '@Robocomp:user'
      ]);

      if (token[1] && user[1]) {
        api.defaults.headers.authorization = `Bearer ${token[1]}`;

        setData({ token: token[1], user: JSON.parse(user[1]) })
      }
      setLoading(false);
    }

    loadStorageData();

  }, []);

  const signIn = useCallback(async ({ cpf, password }) => {
    console.log('ENTREI');
    try {
      const response = await api.post('session', {
        document: cpf,
        password,
      });
      console.log(response.data);

      const { token, user } = response.data;

      await AsyncStorage.multiSet([
        ['@Robocomp:token', token],
        ['@Robocomp:user', JSON.stringify(user)],
      ]);

      api.defaults.headers.authorization = `Bearer ${token}`;

      setData({ token, user });
    } catch (err) {
      console.log(err.response.data.message);
      if (err.response.data.message === "Inactive account") {
        Alert.alert("Sua conta ainda não foi ativada, entre em contato com suporte!");
      } else {
        Alert.alert("Email ou senha incorreto");
      }
    }
  }, []);

  const signOut = useCallback(async () => {
    await AsyncStorage.multiRemove(['@Robocomp:token', '@Robocomp:user']);

    setData({} as AuthState);
  }, []);

  const updateUser = useCallback(
    async (user: User) => {
      console.log(user)
      await AsyncStorage.setItem('@Robocomp:user', JSON.stringify(user));

      setData({ token: data.token, user })
    }, [setData, data.token]);

  /* const handleVerify = useCallback(async(phone: string) => {
    try {
      const response = await smstk.post('verify', {
        key : "F623KUDF82XQLP7GEYFX0GB3CCK7RLFZHRGVSQTR1FPLEOJGTVW8LYBSINACFTEPTEMDG07FD4JE5UK68HFDKRR0ER77J8GVTBZUPQV70FMQTVYR4QP0K5P85TK08OA6",
        number: phone,
        template : "<Robocomp INFORMA> Seu código de verificação: {999-999}",
        expire : 300
      });
      return response.data;
    } catch (error) {
      console.log(error)
    }
  },[]);

  const handleCheck = useCallback(async(phone: string, code: string) => {
    try {
      const response = await smstk.post('check', {
        key : "F623KUDF82XQLP7GEYFX0GB3CCK7RLFZHRGVSQTR1FPLEOJGTVW8LYBSINACFTEPTEMDG07FD4JE5UK68HFDKRR0ER77J8GVTBZUPQV70FMQTVYR4QP0K5P85TK08OA6",
        number: phone,
        code
      })
      return response.data;
    } catch (error) {
      console.log(error)
    }
  },[]); */

  return (
    <AuthContext.Provider value={{ user: data.user, loading, signIn, signOut, updateUser /*, handleVerify, handleCheck */ }}>
      {children}
    </AuthContext.Provider>
  );
};//useAuth

function useAuth(): AuthContextData {
  const context = useContext(AuthContext);

  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }

  return context;
}

export { AuthProvider, useAuth };