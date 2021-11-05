import React, { createContext, useCallback, useContext, useEffect, useState } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Alert } from 'react-native';

interface User {
    id: string;
    plan_id?: number;
    user_type_id: number;
    name: string;
    nickname: string;
    cpf: string;
    email: string;
    phone?: string;
    birth?: Date;
    photo?: string;
    num_rating?: number;
    tot_rating?: number;
};