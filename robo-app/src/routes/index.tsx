import React, { useState } from 'react';
import { ActivityIndicator, View } from 'react-native';
// import { useStateLinkUnmounted } from '@hookstate/core';

import AuthRoutes from './auth.routes';
import AdmRoutes from './adm.routes';
import EmpresaRoutes from './empresa.routes';
import UserRoutes from './usuario.routes';
import { useAuth } from '../hooks/auth';

import theme from '../global/styles/theme';

const Routes: React.FC = () => {
  const { user, loading } = useAuth()

  return (!user ? < AuthRoutes /> :
    (
      (user.user_type_id === 1 && <AdmRoutes />)
      ||
      (user.user_type_id === 2 && <UserRoutes />)
      ||
      (user.user_type_id === 3 && <EmpresaRoutes />)
    )
  );
};

export default Routes;