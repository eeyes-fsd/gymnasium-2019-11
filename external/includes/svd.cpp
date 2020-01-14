/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * svd.cpp
 *
 * Code generation for function 'svd'
 *
 */

/* Include files */
#include <math.h>
#include <string.h>
#include "rt_nonfinite.h"
#include "indefinite_solve.h"
#include "svd.h"
#include "indefinite_solve_emxutil.h"
#include "xaxpy.h"
#include "xdotc.h"
#include "xnrm2.h"
#include "xscal.h"
#include "xrot.h"
#include "xrotg.h"
#include "sqrt.h"
#include "xswap.h"

/* Function Definitions */
void svd(const emxArray_real_T *A, double U_data[], int U_size[2], double
         s_data[], int s_size[1], emxArray_real_T *V)
{
  emxArray_real_T *b_A;
  int i1;
  int qs;
  int p;
  int ns;
  int minnp;
  double b_s_data[4];
  emxArray_real_T *e;
  double work[3];
  int nrt;
  int nct;
  int q;
  int m;
  int iter;
  boolean_T apply_transform;
  double ztest0;
  int jj;
  double ztest;
  double snorm;
  emxArray_real_T b_U_data;
  boolean_T exitg1;
  emxArray_real_T c_U_data;
  double f;
  double scale;
  double sqds;
  double b;
  emxInit_real_T(&b_A, 2);
  i1 = b_A->size[0] * b_A->size[1];
  b_A->size[0] = 3;
  b_A->size[1] = A->size[1];
  emxEnsureCapacity_real_T(b_A, i1);
  qs = A->size[0] * A->size[1];
  for (i1 = 0; i1 < qs; i1++) {
    b_A->data[i1] = A->data[i1];
  }

  p = A->size[1];
  ns = A->size[1];
  if (4 < ns) {
    ns = 4;
  }

  minnp = A->size[1];
  if (3 < minnp) {
    minnp = 3;
  }

  if (0 <= ns - 1) {
    memset(&b_s_data[0], 0, (unsigned int)(ns * (int)sizeof(double)));
  }

  emxInit_real_T1(&e, 1);
  ns = A->size[1];
  i1 = e->size[0];
  e->size[0] = ns;
  emxEnsureCapacity_real_T1(e, i1);
  for (i1 = 0; i1 < ns; i1++) {
    e->data[i1] = 0.0;
  }

  for (ns = 0; ns < 3; ns++) {
    work[ns] = 0.0;
  }

  U_size[0] = 3;
  U_size[1] = minnp;
  qs = 3 * minnp;
  for (i1 = 0; i1 < qs; i1++) {
    U_data[i1] = 0.0;
  }

  ns = A->size[1];
  qs = A->size[1];
  i1 = V->size[0] * V->size[1];
  V->size[0] = ns;
  V->size[1] = qs;
  emxEnsureCapacity_real_T(V, i1);
  qs *= ns;
  for (i1 = 0; i1 < qs; i1++) {
    V->data[i1] = 0.0;
  }

  if (A->size[1] == 0) {
    for (ns = 0; ns < minnp; ns++) {
      U_data[ns + U_size[0] * ns] = 1.0;
    }
  } else {
    if (A->size[1] > 2) {
      nrt = A->size[1] - 2;
    } else {
      nrt = 0;
    }

    if (!(nrt < 3)) {
      nrt = 3;
    }

    nct = A->size[1];
    if (2 < nct) {
      nct = 2;
    }

    if (nct > nrt) {
      i1 = nct;
    } else {
      i1 = nrt;
    }

    for (q = 0; q < i1; q++) {
      iter = q + 3 * q;
      apply_transform = false;
      if (q + 1 <= nct) {
        ztest0 = xnrm2(3 - q, b_A, iter + 1);
        if (ztest0 > 0.0) {
          apply_transform = true;
          if (b_A->data[iter] < 0.0) {
            ztest0 = -ztest0;
          }

          b_s_data[q] = ztest0;
          if (fabs(b_s_data[q]) >= 1.0020841800044864E-292) {
            xscal(3 - q, 1.0 / b_s_data[q], b_A, iter + 1);
          } else {
            ns = (iter - q) + 3;
            for (qs = iter; qs < ns; qs++) {
              b_A->data[qs] /= b_s_data[q];
            }
          }

          b_A->data[iter]++;
          b_s_data[q] = -b_s_data[q];
        } else {
          b_s_data[q] = 0.0;
        }
      }

      for (jj = q + 1; jj < p; jj++) {
        ns = q + 3 * jj;
        if (apply_transform) {
          ztest0 = -(xdotc(3 - q, b_A, iter + 1, b_A, ns + 1) / b_A->data[q +
                     b_A->size[0] * q]);
          xaxpy(3 - q, ztest0, iter + 1, b_A, ns + 1);
        }

        e->data[jj] = b_A->data[ns];
      }

      if (q + 1 <= nct) {
        for (ns = q; ns + 1 < 4; ns++) {
          U_data[ns + U_size[0] * q] = b_A->data[ns + b_A->size[0] * q];
        }
      }

      if (q + 1 <= nrt) {
        iter = p - q;
        ztest0 = b_xnrm2(iter - 1, e, q + 2);
        if (ztest0 == 0.0) {
          e->data[q] = 0.0;
        } else {
          if (e->data[q + 1] < 0.0) {
            ztest0 = -ztest0;
          }

          e->data[q] = ztest0;
          ztest0 = e->data[q];
          if (fabs(e->data[q]) >= 1.0020841800044864E-292) {
            ztest0 = 1.0 / e->data[q];
            ns = q + iter;
            for (qs = q + 1; qs < ns; qs++) {
              e->data[qs] *= ztest0;
            }
          } else {
            ns = q + iter;
            for (qs = q + 1; qs < ns; qs++) {
              e->data[qs] /= ztest0;
            }
          }

          e->data[q + 1]++;
          e->data[q] = -e->data[q];
          if (q + 2 <= 3) {
            for (ns = q + 1; ns + 1 < 4; ns++) {
              work[ns] = 0.0;
            }

            for (jj = q + 1; jj < p; jj++) {
              b_xaxpy(2 - q, e->data[jj], b_A, (q + 3 * jj) + 2, work, q + 2);
            }

            for (jj = q + 1; jj < p; jj++) {
              c_xaxpy(2 - q, -e->data[jj] / e->data[q + 1], work, q + 2, b_A, (q
                       + 3 * jj) + 2);
            }
          }
        }

        for (ns = q + 1; ns < p; ns++) {
          V->data[ns + V->size[0] * q] = e->data[ns];
        }
      }
    }

    m = A->size[1];
    if (!(m < 4)) {
      m = 4;
    }

    if (nct < A->size[1]) {
      b_s_data[nct] = b_A->data[nct + b_A->size[0] * nct];
    }

    if (3 < m) {
      b_s_data[3] = 0.0;
    }

    if (nrt + 1 < m) {
      e->data[nrt] = b_A->data[nrt + b_A->size[0] * (m - 1)];
    }

    e->data[m - 1] = 0.0;
    if (nct + 1 <= minnp) {
      for (jj = nct; jj < minnp; jj++) {
        for (ns = 0; ns < 3; ns++) {
          U_data[ns + U_size[0] * jj] = 0.0;
        }

        U_data[jj + U_size[0] * jj] = 1.0;
      }
    }

    for (q = nct - 1; q + 1 > 0; q--) {
      iter = q + 3 * q;
      if (b_s_data[q] != 0.0) {
        for (jj = q + 1; jj < minnp; jj++) {
          ns = (q + 3 * jj) + 1;
          i1 = b_A->size[0] * b_A->size[1];
          b_A->size[0] = 3;
          b_A->size[1] = U_size[1];
          emxEnsureCapacity_real_T(b_A, i1);
          qs = U_size[0] * U_size[1];
          for (i1 = 0; i1 < qs; i1++) {
            b_A->data[i1] = U_data[i1];
          }

          b_U_data.data = (double *)U_data;
          b_U_data.size = (int *)U_size;
          b_U_data.allocatedSize = -1;
          b_U_data.numDimensions = 2;
          b_U_data.canFreeData = false;
          c_U_data.data = (double *)U_data;
          c_U_data.size = (int *)U_size;
          c_U_data.allocatedSize = -1;
          c_U_data.numDimensions = 2;
          c_U_data.canFreeData = false;
          xaxpy(3 - q, -(xdotc(3 - q, &b_U_data, iter + 1, &c_U_data, ns) /
                         U_data[iter]), iter + 1, b_A, ns);
          U_size[0] = 3;
          U_size[1] = b_A->size[1];
          qs = b_A->size[0] * b_A->size[1];
          for (i1 = 0; i1 < qs; i1++) {
            U_data[i1] = b_A->data[i1];
          }
        }

        for (ns = q; ns + 1 < 4; ns++) {
          U_data[ns + U_size[0] * q] = -U_data[ns + U_size[0] * q];
        }

        U_data[iter]++;
        ns = 1;
        while (ns <= q) {
          U_data[U_size[0] * q] = 0.0;
          ns = 2;
        }
      } else {
        for (ns = 0; ns < 3; ns++) {
          U_data[ns + U_size[0] * q] = 0.0;
        }

        U_data[iter] = 1.0;
      }
    }

    for (q = A->size[1] - 1; q + 1 > 0; q--) {
      if ((q + 1 <= nrt) && (e->data[q] != 0.0)) {
        iter = (p - q) - 1;
        ns = (q + p * q) + 2;
        for (jj = q + 1; jj < p; jj++) {
          qs = (q + p * jj) + 2;
          ztest0 = -(b_xdotc(iter, V, ns, V, qs) / V->data[ns - 1]);
          d_xaxpy(iter, ztest0, ns, V, qs);
        }
      }

      for (ns = 1; ns <= p; ns++) {
        V->data[(ns + V->size[0] * q) - 1] = 0.0;
      }

      V->data[q + V->size[0] * q] = 1.0;
    }

    for (q = 0; q < m; q++) {
      if (b_s_data[q] != 0.0) {
        ztest = fabs(b_s_data[q]);
        ztest0 = b_s_data[q] / ztest;
        b_s_data[q] = ztest;
        if (q + 1 < m) {
          e->data[q] /= ztest0;
        }

        if (q + 1 <= 3) {
          b_xscal(ztest0, U_data, 1 + 3 * q);
        }
      }

      if ((q + 1 < m) && (e->data[q] != 0.0)) {
        ztest = fabs(e->data[q]);
        ztest0 = ztest / e->data[q];
        e->data[q] = ztest;
        b_s_data[q + 1] *= ztest0;
        c_xscal(p, ztest0, V, 1 + p * (q + 1));
      }
    }

    nct = m;
    iter = 0;
    snorm = 0.0;
    for (ns = 0; ns < m; ns++) {
      ztest0 = fabs(b_s_data[ns]);
      ztest = fabs(e->data[ns]);
      if ((ztest0 > ztest) || rtIsNaN(ztest)) {
      } else {
        ztest0 = ztest;
      }

      if (!((snorm > ztest0) || rtIsNaN(ztest0))) {
        snorm = ztest0;
      }
    }

    while ((m > 0) && (!(iter >= 75))) {
      q = m - 1;
      exitg1 = false;
      while (!(exitg1 || (q == 0))) {
        ztest0 = fabs(e->data[q - 1]);
        if ((ztest0 <= 2.2204460492503131E-16 * (fabs(b_s_data[q - 1]) + fabs
              (b_s_data[q]))) || (ztest0 <= 1.0020841800044864E-292) || ((iter >
              20) && (ztest0 <= 2.2204460492503131E-16 * snorm))) {
          e->data[q - 1] = 0.0;
          exitg1 = true;
        } else {
          q--;
        }
      }

      if (q == m - 1) {
        ns = 4;
      } else {
        qs = m;
        ns = m;
        exitg1 = false;
        while ((!exitg1) && (ns >= q)) {
          qs = ns;
          if (ns == q) {
            exitg1 = true;
          } else {
            ztest0 = 0.0;
            if (ns < m) {
              ztest0 = fabs(e->data[ns - 1]);
            }

            if (ns > q + 1) {
              ztest0 += fabs(e->data[ns - 2]);
            }

            ztest = fabs(b_s_data[ns - 1]);
            if ((ztest <= 2.2204460492503131E-16 * ztest0) || (ztest <=
                 1.0020841800044864E-292)) {
              b_s_data[ns - 1] = 0.0;
              exitg1 = true;
            } else {
              ns--;
            }
          }
        }

        if (qs == q) {
          ns = 3;
        } else if (qs == m) {
          ns = 1;
        } else {
          ns = 2;
          q = qs;
        }
      }

      switch (ns) {
       case 1:
        f = e->data[m - 2];
        e->data[m - 2] = 0.0;
        for (qs = m - 3; qs + 2 >= q + 1; qs--) {
          xrotg(&b_s_data[qs + 1], &f, &ztest0, &ztest);
          if (qs + 2 > q + 1) {
            f = -ztest * e->data[qs];
            e->data[qs] *= ztest0;
          }

          xrot(p, V, 1 + p * (qs + 1), 1 + p * (m - 1), ztest0, ztest);
        }
        break;

       case 2:
        f = e->data[q - 1];
        e->data[q - 1] = 0.0;
        for (qs = q; qs < m; qs++) {
          xrotg(&b_s_data[qs], &f, &ztest0, &ztest);
          f = -ztest * e->data[qs];
          e->data[qs] *= ztest0;
          b_xrot(U_data, 1 + 3 * qs, 1 + 3 * (q - 1), ztest0, ztest);
        }
        break;

       case 3:
        scale = fabs(b_s_data[m - 1]);
        ztest = fabs(b_s_data[m - 2]);
        if (!((scale > ztest) || rtIsNaN(ztest))) {
          scale = ztest;
        }

        ztest = fabs(e->data[m - 2]);
        if (!((scale > ztest) || rtIsNaN(ztest))) {
          scale = ztest;
        }

        ztest = fabs(b_s_data[q]);
        if (!((scale > ztest) || rtIsNaN(ztest))) {
          scale = ztest;
        }

        ztest = fabs(e->data[q]);
        if (!((scale > ztest) || rtIsNaN(ztest))) {
          scale = ztest;
        }

        f = b_s_data[m - 1] / scale;
        ztest0 = b_s_data[m - 2] / scale;
        ztest = e->data[m - 2] / scale;
        sqds = b_s_data[q] / scale;
        b = ((ztest0 + f) * (ztest0 - f) + ztest * ztest) / 2.0;
        ztest0 = f * ztest;
        ztest0 *= ztest0;
        if ((b != 0.0) || (ztest0 != 0.0)) {
          ztest = b * b + ztest0;
          b_sqrt(&ztest);
          if (b < 0.0) {
            ztest = -ztest;
          }

          ztest = ztest0 / (b + ztest);
        } else {
          ztest = 0.0;
        }

        f = (sqds + f) * (sqds - f) + ztest;
        b = sqds * (e->data[q] / scale);
        for (qs = q + 1; qs < m; qs++) {
          xrotg(&f, &b, &ztest0, &ztest);
          if (qs > q + 1) {
            e->data[qs - 2] = f;
          }

          f = ztest0 * b_s_data[qs - 1] + ztest * e->data[qs - 1];
          e->data[qs - 1] = ztest0 * e->data[qs - 1] - ztest * b_s_data[qs - 1];
          b = ztest * b_s_data[qs];
          b_s_data[qs] *= ztest0;
          xrot(p, V, 1 + p * (qs - 1), 1 + p * qs, ztest0, ztest);
          b_s_data[qs - 1] = f;
          xrotg(&b_s_data[qs - 1], &b, &ztest0, &ztest);
          f = ztest0 * e->data[qs - 1] + ztest * b_s_data[qs];
          b_s_data[qs] = -ztest * e->data[qs - 1] + ztest0 * b_s_data[qs];
          b = ztest * e->data[qs];
          e->data[qs] *= ztest0;
          if (qs < 3) {
            b_xrot(U_data, 1 + 3 * (qs - 1), 1 + 3 * qs, ztest0, ztest);
          }
        }

        e->data[m - 2] = f;
        iter++;
        break;

       default:
        if (b_s_data[q] < 0.0) {
          b_s_data[q] = -b_s_data[q];
          c_xscal(p, -1.0, V, 1 + p * q);
        }

        ns = q + 1;
        while ((q + 1 < nct) && (b_s_data[q] < b_s_data[ns])) {
          ztest = b_s_data[q];
          b_s_data[q] = b_s_data[ns];
          b_s_data[ns] = ztest;
          if (q + 1 < p) {
            b_xswap(p, V, 1 + p * q, 1 + p * (q + 1));
          }

          if (q + 1 < 3) {
            i1 = b_A->size[0] * b_A->size[1];
            b_A->size[0] = 3;
            b_A->size[1] = U_size[1];
            emxEnsureCapacity_real_T(b_A, i1);
            qs = U_size[0] * U_size[1];
            for (i1 = 0; i1 < qs; i1++) {
              b_A->data[i1] = U_data[i1];
            }

            xswap(b_A, 1 + 3 * q, 1 + 3 * (q + 1));
            U_size[0] = 3;
            U_size[1] = b_A->size[1];
            qs = b_A->size[0] * b_A->size[1];
            for (i1 = 0; i1 < qs; i1++) {
              U_data[i1] = b_A->data[i1];
            }
          }

          q = ns;
          ns++;
        }

        iter = 0;
        m--;
        break;
      }
    }
  }

  emxFree_real_T(&e);
  emxFree_real_T(&b_A);
  s_size[0] = minnp;
  for (qs = 0; qs < minnp; qs++) {
    s_data[qs] = b_s_data[qs];
  }
}

/* End of code generation (svd.cpp) */
