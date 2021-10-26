// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import {
    Alert, Image, ImageBackground,
    ScrollView, StyleSheet, TouchableNativeFeedback,
    TouchableOpacity, View
} from 'react-native';
import { IconButton, Text, TouchableRipple } from 'react-native-paper';
import { useStateLinkUnmounted } from '@hookstate/core';
import { FontAwesome5 } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';

// Import de páginas
import TextInput from '../../components/Input';
import Container, { ContainerTop } from '../../components/Container';
import request from '../../util/request';
import theme from '../../global/styles/theme';
import { Button } from '../../components/Button';
import { StateUser } from '../../context/auth';
import GlobalContext from '../../context';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function EditService() {
    const [loading, setLoading] = useState(false);
    const [comentario, setComentario] = useState('');
    const [categorias, setCategorias] = useState('');
    const [id, setID] = useState('');
    const [title, setTitle] = useState('');
    const [price, setPrice] = useState('');
    const [arrayCategory, setArrayCategory] = useState(['']);
    const [tam, setTam] = useState('');

    var price2;

    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => console.log('goBack()')}
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}>
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles.textStyleF}>
                            RoboComp - Editar Serviço
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView style={styles.scrollView}>
                <Container pb />
                <Container horizontal pt>
                    <View>
                        <Text
                            style={{
                                marginBottom: 7,
                                marginRight: 10,
                                fontSize: 20,
                                fontFamily: 'Manjari-Bold',
                                width: '90%',
                            }}>
                            Adicionar fotos ao serviço:
                        </Text>
                    </View>
                </Container>
                <Container>
                    <Text style={styles.title}>Categoria:</Text>
                    <Text style={styles.title2}>{categorias}</Text>
                    <Text style={styles.title}>Subcategoria:</Text>
                    <Text style={styles.title2}>{title}</Text>
                    <Text style={styles.title}>Preço:</Text>
                    <Text style={styles.title2}>{price}</Text>
                </Container>
                <Container horizontal vertical>
                    <Text>Descrição:</Text>
                    <TextInput
                        value={comentario} setValue={setComentario} />
                </Container>
                <Container horizontal vertical>
                    <Button
                        onPress={() => console.log('submit')} //submit para funcionar o CRUD
                        text="SALVAR SERVIÇO"
                        fullWidth
                        loading={loading}
                        backgroundColor={theme.colors.newcolor}
                    />
                </Container>
            </ScrollView>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
    },
    textStyle: {
        fontSize: 20,
        fontFamily: 'Manjari-bold',
        color: 'white',
        textAlign: 'center',
    },

    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    title: {
        fontSize: 16,
        fontWeight: 'bold',
        paddingLeft: '4%',
        paddingTop: '4%',
        marginBottom: -10
    },
    title2: {
        fontSize: 16,
        paddingLeft: '4%',
        paddingTop: '4%',
        marginBottom: -10
    },
    inputMask: {
        marginHorizontal: '3%',
        borderBottomColor: '#C5C3C2',
        borderBottomWidth: 2,
    },
    inputask: {
        marginHorizontal: '3%',
        borderBottomColor: '#000',
        borderBottomWidth: 2,
    },
    radio: {
        margin: 10,
        flexDirection: 'row',
        alignItems: 'center',
        minWidth: '39%',
    },
    radioGroup: {
        width: '90%',
        margin: 15,
        flexDirection: 'row',
        flexWrap: 'wrap',
    },
});