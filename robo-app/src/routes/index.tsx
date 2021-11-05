import React from 'react';
import { ActivityIndicator, View } from 'react-native';

import AuthRoutes from './auth.routes';
import AdmRoutes from './adm.routes';
import EmpresaRoutes from './empresa.routes';
import UserRoutes from './usuario.routes';

import theme from '../global/styles/theme';
import { StateUser } from '../context/auth';

const Routes: React.FC = () => {
//   const { user, loading } = StateUser();

//   if(loading) {
    // return (
    //   <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor:theme.colors.middlecolor}}>
    //     {/* <ActivityIndicator size="large" color="#3CB8B8" /> */}
    //   </View>
    // )
//   }

  return < AuthRoutes/>
//   return user ? (user.user_type_id === 5 ? <GeneratorRoutes /> : <CollectorRoutes/>) : < AuthRoutes/>
  // return <CollectorRoutes/>
};

export default Routes;