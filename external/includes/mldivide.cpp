/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * mldivide.cpp
 *
 * Code generation for function 'mldivide'
 *
 */

/* Include files */
#include <math.h>
#include "rt_nonfinite.h"
#include "indefinite_solve.h"
#include "mldivide.h"
#include "indefinite_solve_emxutil.h"
#include "xgeqp3.h"

/* Function Definitions */
void mldivide(const emxArray_real_T *A, const double B[3], emxArray_real_T *Y)
{
  int i0;
  emxArray_real_T *b_A;
  int minmn;
  double A_data[9];
  int j;
  signed char ipiv[3];
  int maxmn;
  int c;
  emxArray_int32_T *jpvt;
  double tau_data[3];
  int tau_size[1];
  double b_B[3];
  int ix;
  int rankR;
  double tol;
  double s;
  int ijA;
  if (A->size[1] == 0) {
    i0 = Y->size[0];
    Y->size[0] = 0;
    emxEnsureCapacity_real_T1(Y, i0);
  } else if (3 == A->size[1]) {
    minmn = A->size[0] * A->size[1];
    for (i0 = 0; i0 < minmn; i0++) {
      A_data[i0] = A->data[i0];
    }

    for (i0 = 0; i0 < 3; i0++) {
      ipiv[i0] = (signed char)(1 + i0);
    }

    for (j = 0; j < 2; j++) {
      c = j << 2;
      minmn = 0;
      ix = c;
      tol = fabs(A_data[c]);
      for (rankR = 2; rankR <= 3 - j; rankR++) {
        ix++;
        s = fabs(A_data[ix]);
        if (s > tol) {
          minmn = rankR - 1;
          tol = s;
        }
      }

      if (A_data[c + minmn] != 0.0) {
        if (minmn != 0) {
          ipiv[j] = (signed char)((j + minmn) + 1);
          ix = j;
          minmn += j;
          for (rankR = 0; rankR < 3; rankR++) {
            tol = A_data[ix];
            A_data[ix] = A_data[minmn];
            A_data[minmn] = tol;
            ix += 3;
            minmn += 3;
          }
        }

        i0 = (c - j) + 3;
        for (maxmn = c + 1; maxmn < i0; maxmn++) {
          A_data[maxmn] /= A_data[c];
        }
      }

      minmn = c;
      maxmn = c + 3;
      for (rankR = 1; rankR <= 2 - j; rankR++) {
        tol = A_data[maxmn];
        if (A_data[maxmn] != 0.0) {
          ix = c + 1;
          i0 = (minmn - j) + 6;
          for (ijA = 4 + minmn; ijA < i0; ijA++) {
            A_data[ijA] += A_data[ix] * -tol;
            ix++;
          }
        }

        maxmn += 3;
        minmn += 3;
      }
    }

    for (maxmn = 0; maxmn < 3; maxmn++) {
      b_B[maxmn] = B[maxmn];
    }

    for (minmn = 0; minmn < 2; minmn++) {
      if (ipiv[minmn] != minmn + 1) {
        tol = b_B[minmn];
        b_B[minmn] = b_B[ipiv[minmn] - 1];
        b_B[ipiv[minmn] - 1] = tol;
      }
    }

    for (rankR = 0; rankR < 3; rankR++) {
      minmn = 3 * rankR;
      if (b_B[rankR] != 0.0) {
        for (maxmn = rankR + 1; maxmn + 1 < 4; maxmn++) {
          b_B[maxmn] -= b_B[rankR] * A_data[maxmn + minmn];
        }
      }
    }

    for (rankR = 2; rankR >= 0; rankR--) {
      minmn = 3 * rankR;
      if (b_B[rankR] != 0.0) {
        b_B[rankR] /= A_data[rankR + minmn];
        for (maxmn = 0; maxmn < rankR; maxmn++) {
          b_B[maxmn] -= b_B[rankR] * A_data[maxmn + minmn];
        }
      }
    }

    i0 = Y->size[0];
    Y->size[0] = 3;
    emxEnsureCapacity_real_T1(Y, i0);
    for (i0 = 0; i0 < 3; i0++) {
      Y->data[i0] = b_B[i0];
    }
  } else {
    emxInit_real_T(&b_A, 2);
    i0 = b_A->size[0] * b_A->size[1];
    b_A->size[0] = 3;
    b_A->size[1] = A->size[1];
    emxEnsureCapacity_real_T(b_A, i0);
    minmn = A->size[0] * A->size[1];
    for (i0 = 0; i0 < minmn; i0++) {
      b_A->data[i0] = A->data[i0];
    }

    emxInit_int32_T(&jpvt, 2);
    xgeqp3(b_A, tau_data, tau_size, jpvt);
    rankR = 0;
    if (3 < b_A->size[1]) {
      minmn = 3;
      maxmn = b_A->size[1];
    } else {
      minmn = b_A->size[1];
      maxmn = 3;
    }

    if (minmn > 0) {
      tol = (double)maxmn * fabs(b_A->data[0]) * 2.2204460492503131E-16;
      while ((rankR < minmn) && (!(fabs(b_A->data[rankR + b_A->size[0] * rankR])
               <= tol))) {
        rankR++;
      }
    }

    for (maxmn = 0; maxmn < 3; maxmn++) {
      b_B[maxmn] = B[maxmn];
    }

    minmn = b_A->size[1];
    i0 = Y->size[0];
    Y->size[0] = minmn;
    emxEnsureCapacity_real_T1(Y, i0);
    for (i0 = 0; i0 < minmn; i0++) {
      Y->data[i0] = 0.0;
    }

    minmn = b_A->size[1];
    if (3 < minmn) {
      minmn = 3;
    }

    for (j = 0; j < minmn; j++) {
      if (tau_data[j] != 0.0) {
        tol = b_B[j];
        for (maxmn = j + 1; maxmn + 1 < 4; maxmn++) {
          tol += b_A->data[maxmn + b_A->size[0] * j] * b_B[maxmn];
        }

        tol *= tau_data[j];
        if (tol != 0.0) {
          b_B[j] -= tol;
          for (maxmn = j + 1; maxmn + 1 < 4; maxmn++) {
            b_B[maxmn] -= b_A->data[maxmn + b_A->size[0] * j] * tol;
          }
        }
      }
    }

    for (maxmn = 0; maxmn < rankR; maxmn++) {
      Y->data[jpvt->data[maxmn] - 1] = b_B[maxmn];
    }

    for (j = rankR - 1; j + 1 > 0; j--) {
      Y->data[jpvt->data[j] - 1] /= b_A->data[j + b_A->size[0] * j];
      for (maxmn = 0; maxmn < j; maxmn++) {
        Y->data[jpvt->data[maxmn] - 1] -= Y->data[jpvt->data[j] - 1] * b_A->
          data[maxmn + b_A->size[0] * j];
      }
    }

    emxFree_int32_T(&jpvt);
    emxFree_real_T(&b_A);
  }
}

/* End of code generation (mldivide.cpp) */
